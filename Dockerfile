# syntax=docker/dockerfile:1
FROM composer
COPY ./ /app
WORKDIR /app
RUN composer update && apk add npm && npm run dev
CMD php artisan serve --host=0.0.0.0
EXPOSE 8000
