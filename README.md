
# Satisfactory Savegame Provider

Exposes savegames to the web to load them automatically into [Satisfactory Calculator Interactive Map](https://satisfactory-calculator.com/en/interactive-map), including an endpoint to always get the latest savegame.


## Installation


### Standalone

- Clone the repository
- Configure your webserver to always serve the index.php
- Copy the .env.example to .env and change APP_URL to your domain and SATISFACTORY_SAVEGAME_DIR to the physical location of your savegames.

⚠️ **Attention!** Make sure that the webserver has access to your savegame folder!  
- For me I needed to add the www-data user to the steam group with `sudo useradd www-data steam`. 
- Additonally to that, since my savegame folder was inside a /home folder, I needed to overwrite the systemd service file for php-fpm and set `ProtectHome = false`.

#### Environment Variables

To run this project, you will need to change the following environment variables from the .env.example:

`APP_URL` should be your hostname including http scheme.

`SATISFACTORY_SAVEGAME_DIR` should point to the directory the savegames are saved in (including trailing '/')


### Docker

It's a little bit simpler with Docker.

**docker run**
```bash
docker run -d \
    -p 8000:8000 \
    -v /home/steam/.config/Epic/FactoryGame/Saved/SaveGames/server:/saves \
    -e APP_URL=https://example.com \
    tiifuchs/satisfactory-savegame-provider:latest
```

Make sure to change the port, the savegame folder and your domain.

**docker-compose.yml**
```yaml
services:
  app:
    image: tiifuchs/satisfactory-savegame-provider:latest
    ports:
      - 8000:8000
    volumes:
      - /home/steam/.config/Epic/FactoryGame/Saved/SaveGames/server:/saves
    environment:
      APP_URL: https://example.com
```

Make sure to change the port, the savegame folder and your domain.


## Usage

The following endpoints are available:

- `/latest` always points to the latest savegame
- `/save/<filename>` points to the filename with the corresponding filename
- `/map` redirects to [SCIM](https://satisfactory-calculator.com/en/interactive-map) including a parameter to automatically load the latest savegame.

## License

[MIT](/LICENSE.md)

