package src;

import java.io.*;
import java.net.Socket;
import java.util.logging.*;

public class RequestHandler implements Runnable {
    private static final Logger logger = Logger.getLogger(RequestHandler.class.getName());
    private Socket clientSocket;
    private String rootDirectory;

    static {
        try {
            // Configuration du logger
            LogManager.getLogManager().reset();
            FileHandler fileHandler = new FileHandler("server.log", true); // true pour append
            fileHandler.setFormatter(new SimpleFormatter());
            logger.addHandler(fileHandler);
        } catch (IOException e) {
            System.err.println("Error configuring the logger: " + e.getMessage());
        }
    }

    public RequestHandler(Socket clientSocket, String rootDirectory) {
        this.clientSocket = clientSocket;
        this.rootDirectory = rootDirectory;
    }

    @Override
public void run() {
    try (
        BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
        PrintWriter out = new PrintWriter(clientSocket.getOutputStream());
    ) {
        // Lire la requête HTTP
        String requestLine = in.readLine();
        if (requestLine == null) return;

        System.out.println("Request: " + requestLine);

        // Extraire la méthode et le chemin demandé
        String[] requestParts = requestLine.split(" ");
        if (requestParts.length < 2) return;

        String method = requestParts[0];
        String path = requestParts[1].split("\\?")[0];

        // La méthode HTTP (GET, POST, PUT, DELETE)
        File file = new File(rootDirectory + path);

        // Gestion de la méthode HTTP
        if (method.equals("POST")) {
            handlePostRequest(path, in, out);
        } else if (method.equals("GET")) {
            if (file.isDirectory()) {
                sendDirectoryListing(file, out);
            } else if (file.isFile()) {
                sendFileContent(file, out);
            } else {
                sendNotFound(out);
            }
        } else if (method.equals("PUT")) {
            handlePutRequest(path, in, out);
        } else if (method.equals("DELETE")) {
            handleDeleteRequest(path, out);
        } else {
            sendMethodNotAllowed(out);
        }
    } catch (IOException e) {
        logger.log(Level.SEVERE, "Error handling request", e);
        // Déplacer le bloc d'erreur pour gérer out dans le même contexte
        try {
            PrintWriter out = new PrintWriter(clientSocket.getOutputStream());
            sendInternalServerError(out);
        } catch (IOException ex) {
            logger.log(Level.SEVERE, "Error sending internal server error", ex);
        }
    } catch (Exception e) {
        logger.log(Level.SEVERE, "Unexpected error", e);
    }
}

    
    // Envoie une liste des fichiers dans un répertoire
    private void sendDirectoryListing(File directory, PrintWriter out) {
        File[] files = directory.listFiles();
        if (files == null) return;

        out.println("HTTP/1.1 200 OK");
        out.println("Content-Type: text/html");
        out.println();
        out.println("<html><body>");
        out.println("<h1>Directory Listing: " + directory.getName() + "</h1>");
        out.println("<ul>");
        for (File file : files) {
            String fileName = file.getName();
            String link = file.isDirectory() ? fileName + "/" : fileName;
            out.println("<li><a href=\"" + link + "\">" + fileName + "</a></li>");
        }
        out.println("</ul>");
        out.println("</body></html>");
    }

    // Envoie le contenu d'un fichier
    private void sendFileContent(File file, PrintWriter out) throws IOException {
        if (file.getName().endsWith(".php")) {
            // Utilisation de l'interpréteur PHP en ligne de commande
            ProcessBuilder processBuilder = new ProcessBuilder("php", file.getAbsolutePath());
            processBuilder.directory(file.getParentFile()); // Définit le répertoire de travail

            Process process = processBuilder.start();

            try (BufferedReader reader = new BufferedReader(new InputStreamReader(process.getInputStream()))) {
                String line;
                while ((line = reader.readLine()) != null) {
                    out.println(line);
                }
            }

            try {
                int exitCode = process.waitFor();
                if (exitCode != 0) {
                    sendInternalServerError(out);
                }
            } catch (InterruptedException e) {
                sendInternalServerError(out);
            }

        } else {
            out.println("HTTP/1.1 200 OK");
            out.println("Content-Type: " + getContentType(file));
            out.println();

            try (BufferedReader reader = new BufferedReader(new FileReader(file))) {
                String line;
                while ((line = reader.readLine()) != null) {
                    out.println(line);
                }
            }
        }
    }

    private void sendInternalServerError(PrintWriter out) {
        out.println("HTTP/1.1 500 Internal Server Error");
        out.println("Content-Type: text/html");
        out.println();
        out.println("<html><body><h1>500 - Internal Server Error</h1></body></html>");
    }

    private void handlePostRequest(String path, BufferedReader in, PrintWriter out) throws IOException {
        // Lire le corps de la requête POST (si besoin)
        int contentLength = 0;
        String line;
        while (!(line = in.readLine()).isEmpty()) {
            if (line.startsWith("Content-Length:")) {
                contentLength = Integer.parseInt(line.substring("Content-Length:".length()).trim());
            }
        }

        // Lire le corps de la requête (les données envoyées)
        char[] body = new char[contentLength];
        in.read(body, 0, contentLength);
        String requestBody = new String(body);

        System.out.println("Données POST reçues sur " + path + ": " + requestBody);

        // Traiter la requête POST (par exemple, afficher les données reçues)
        out.println("HTTP/1.1 200 OK");
        out.println("Content-Type: text/html");
        out.println();
        out.println("<html><body>");
        out.println("<h1>Données reçues via POST</h1>");
        out.println("<p>" + requestBody + "</p>");
        out.println("</body></html>");
    }

    private void handlePutRequest(String path, BufferedReader in, PrintWriter out) throws IOException {
        File file = new File(rootDirectory + path);

        try (BufferedWriter writer = new BufferedWriter(new FileWriter(file))) {
            int contentLength = 0;
            String line;
            while (!(line = in.readLine()).isEmpty()) {
                if (line.startsWith("Content-Length:")) {
                    contentLength = Integer.parseInt(line.substring("Content-Length:".length()).trim());
                }
            }

            char[] body = new char[contentLength];
            in.read(body, 0, contentLength);
            String requestBody = new String(body);

            writer.write(requestBody);
            writer.flush();
        }

        out.println("HTTP/1.1 200 OK");
        out.println("Content-Type: text/html");
        out.println();
        out.println("<html><body>");
        out.println("<h1>Fichier mis à jour avec succès</h1>");
        out.println("</body></html>");
    }

    private void handleDeleteRequest(String path, PrintWriter out) {
        File file = new File(rootDirectory + path);
        if (file.exists() && file.delete()) {
            out.println("HTTP/1.1 200 OK");
            out.println("Content-Type: text/html");
            out.println();
            out.println("<html><body>");
            out.println("<h1>Fichier supprimé avec succès</h1>");
            out.println("</body></html>");
        } else {
            sendNotFound(out);
        }
    }

    private void sendNotFound(PrintWriter out) {
        out.println("HTTP/1.1 404 Not Found");
        out.println("Content-Type: text/html");
        out.println();
        out.println("<html><body><h1>404 - Not Found</h1></body></html>");
    }

    private void sendMethodNotAllowed(PrintWriter out) {
        out.println("HTTP/1.1 405 Method Not Allowed");
        out.println("Content-Type: text/html");
        out.println();
        out.println("<html><body><h1>405 - Method Not Allowed</h1></body></html>");
    }

    private String getContentType(File file) {
        String fileName = file.getName().toLowerCase();
        if (fileName.endsWith(".html")) return "text/html";
        if (fileName.endsWith(".css")) return "text/css";
        if (fileName.endsWith(".js")) return "application/javascript";
        if (fileName.endsWith(".png")) return "image/png";
        if (fileName.endsWith(".jpg") || fileName.endsWith(".jpeg")) return "image/jpeg";
        if (fileName.endsWith(".gif")) return "image/gif";
        if (fileName.endsWith(".txt")) return "text/plain";
        if (fileName.endsWith(".php")) return "text/html";
        return "application/octet-stream";
    }
}
