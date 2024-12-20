package aff;

import src.*;
import java.io.*;
import java.util.Properties;
import java.util.logging.*;

public class Main {
    private static final Logger logger = Logger.getLogger(Main.class.getName());

    public static void main(String[] args) {
        // Définir le chemin du fichier de configuration
        String configFilePath = "config.txt";
        
        // Charger le port depuis le fichier de configuration
        int port = loadPortFromConfig(configFilePath, 8081);  // 8081 est la valeur par défaut
        
        // Répertoire racine des fichiers à servir
        String rootDirectory = "../site";

        // Démarrer le serveur avec le port chargé depuis le fichier de configuration
        HTTPServer server = new HTTPServer(port, rootDirectory);
        server.start();
    }

    // Méthode pour charger le port depuis un fichier de configuration
    private static int loadPortFromConfig(String configFilePath, int defaultPort) {
        try (FileReader reader = new FileReader(configFilePath)) {
            Properties properties = new Properties();
            properties.load(reader);
            
            // Lire la valeur du port dans le fichier et retourner l'entier
            String portString = properties.getProperty("port");
            if (portString != null) {
                return Integer.parseInt(portString);
            }
        } catch (IOException e) {
            logger.severe("Erreur lors de la lecture du fichier de configuration : " + e.getMessage());
        } catch (NumberFormatException e) {
            logger.warning("Format de port invalide dans le fichier de configuration : " + e.getMessage());
        }
        
        // Si le fichier est absent ou le port non spécifié, retourner la valeur par défaut
        return defaultPort;
    }
}
