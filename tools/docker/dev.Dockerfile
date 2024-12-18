FROM alpine@sha256:21dc6063fd678b478f57c0e13f47560d0ea4eeba26dfc947b2a4f81f686b9f45

RUN apk update && apk upgrade && \
    apk add bash && \
    apk add nginx && \
    apk add php83 php83-fpm php83-opcache php83-zlib php83-curl php83-mbstring php83-session

COPY etc/nginx /etc/nginx
COPY etc/php83 /etc/php83
COPY entrypoint.sh /

RUN mkdir /var/run/php

EXPOSE 80

STOPSIGNAL SIGTERM

CMD [ "sh", "/entrypoint.sh" ]
