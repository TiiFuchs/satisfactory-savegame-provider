
# Satisfactory Savegame Provider

Exposes savegames to the web to load them automatically into [Satisfactory Calculator Interactive Map](https://satisfactory-calculator.com/en/interactive-map), including an endpoint to always get the latest savegame.
## Environment Variables

To run this project, you will need to change the following environment variables from the .env.example:

`APP_URL` should be your hostname including http scheme.

`SATISFACTORY_SAVEGAME_DIR` should point to the directory the savegames are saved in (including trailing '/')


## Usage

The following endpoints are available:

- `/latest` always points to the latest savegame
- `/save/<filename>` points to the filename with the corresponding filename
- `/map` redirects to [SCIM](https://satisfactory-calculator.com/en/interactive-map) including a parameter to automatically load the latest savegame.

## License

[MIT](https://choosealicense.com/licenses/mit/)

