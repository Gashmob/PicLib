# syntax=docker/dockerfile:1
FROM alpine@sha256:21dc6063fd678b478f57c0e13f47560d0ea4eeba26dfc947b2a4f81f686b9f45

# Install dependencies
RUN apk update && apk upgrade && \
    apk add nginx && \
    apk add php83 php83-fpm php83-opcache php83-zlib php83-curl php83-mbstring php83-session

# Copy configuration files
COPY --from=project tools/docker/etc/nginx /etc/nginx
COPY --from=project tools/docker/etc/php83 /etc/php83
COPY --from=project tools/docker/entrypoint.sh /
RUN mkdir /var/run/php

# Copy sources
COPY --chown=nginx:nginx --from=project config /app/config
COPY --chown=nginx:nginx --from=project public /app/public
COPY --chown=nginx:nginx --from=project src /app/src
COPY --chown=nginx:nginx --from=project templates /app/templates
COPY --chown=nginx:nginx --from=project vendor /app/vendor
COPY --chown=nginx:nginx --from=project composer.json /app/
COPY --chown=nginx:nginx --from=project .env.prod /app/.env
COPY --chown=nginx:nginx --from=project VERSION /app/
RUN mkdir /app/cache && chmod 777 /app/cache

EXPOSE 80

STOPSIGNAL SIGTERM

CMD [ "sh", "/entrypoint.sh" ]
