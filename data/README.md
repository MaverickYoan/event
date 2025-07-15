# Configuration PGAdmin pour PostgreSQL Docker

Ce fichier `config.json` permet de configurer automatiquement la connexion entre PGAdmin et PostgreSQL dans votre environnement Docker.

## Structure et explication du fichier config.json

```json
{
	"Servers": {
		"1": {
			// Identifiant unique du serveur
			"Name": "PostgreSQL Docker", // Nom affiché dans l'interface PGAdmin
			"Group": "Servers", // Groupe auquel appartient le serveur
			"Host": "db", // Nom d'hôte (nom du service dans docker-compose)
			"Port": 5432, // Port PostgreSQL standard
			"MaintenanceDB": "introsql", // Base de données par défaut
			"Username": "test", // Nom d'utilisateur
			"Password": "test", // Mot de passe
			"SSLMode": "prefer" // Mode de connexion SSL
		}
	}
}
```

## Fonctionnement avec Docker

Dans le fichier `docker-compose.yml`, ce fichier est monté dans le conteneur PGAdmin à l'emplacement `/pgadmin4/servers.json` via la configuration de volume:

```yaml
pgadmin:
  # ...autres configurations...
  environment:
    # ...autres variables d'environnement...
    PGADMIN_SERVER_JSON_FILE: /pgadmin4/servers.json
  volumes:
    - ./data/config.json:/pgadmin4/servers.json
```

Cela permet à PGAdmin de se connecter automatiquement à votre base de données PostgreSQL sans avoir besoin de configurer manuellement la connexion à chaque démarrage des conteneurs.

## Comment l'utiliser

1. Lorsque vous accédez à PGAdmin via `http://localhost:8080` (changer le port si nécessaire)
2. Connectez-vous avec les identifiants configurés (admin@admin.com / admin)
3. Vous verrez automatiquement le serveur "PostgreSQL Docker" dans le panneau de gauche
4. Vous pourrez y accéder directement sans configuration supplémentaire
