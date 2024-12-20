package src;

import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.logging.*;

public class HTTPServer {
    private int port;
    private String rootDirectory;
    private static final Logger logger = Logger.getLogger(HTTPServer.class.getName());


    public HTTPServer(int port, String rootDirectory) {
        this.port = port;
        this.rootDirectory = rootDirectory;
    }

    public void start() {
    try (ServerSocket serverSocket = new ServerSocket(port)) {
        System.out.println("Server started on port: " + port);
        System.out.println("Serving files from: " + rootDirectory);

        while (true) {
            try {
                Socket clientSocket = serverSocket.accept();
                System.out.println("New connection from: " + clientSocket.getInetAddress());
                new Thread(new RequestHandler(clientSocket, rootDirectory)).start();
            } catch (IOException e) {
                logger.log(Level.SEVERE, "Error handling client connection", e);
            }
        }
    } catch (IOException e) {
        logger.log(Level.SEVERE, "Error starting server", e);
    }
}

}
