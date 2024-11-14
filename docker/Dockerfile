FROM composer AS build
ADD . /app
RUN composer install --no-interaction --no-dev --optimize-autoloader

FROM php:8.3
WORKDIR /app
COPY --from=build /app /app

EXPOSE 8000
VOLUME /saves
ENV APP_URL=http://example.com
ENV SATISFACTORY_SAVEGAME_DIR=/saves

CMD [ "php", "-S", "0.0.0.0:8000", "index.php"]