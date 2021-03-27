FROM debian:buster AS voikko
RUN apt-get update && apt-get install -y build-essential curl libz-dev libreadline-dev python3

RUN curl -LO https://bitbucket.org/mhulden/foma/downloads/foma-0.9.18.tar.gz
RUN tar xzf foma-0.9.18.tar.gz
WORKDIR foma-0.9.18
RUN make && make install
WORKDIR ..

RUN curl -LO https://www.puimula.org/voikko-sources/libvoikko/libvoikko-4.3.1.tar.gz
RUN tar xzf libvoikko-4.3.1.tar.gz
WORKDIR libvoikko-4.3.1
RUN ./configure --prefix=/usr --with-dictionary-path=/usr/share/voikko --disable-hfst --disable-static && make && make install
WORKDIR ..

RUN curl -LO https://www.puimula.org/voikko-sources/voikko-fi/voikko-fi-2.4.tar.gz
RUN tar xzf voikko-fi-2.4.tar.gz
WORKDIR voikko-fi-2.4
RUN make vvfst && make vvfst-install DESTDIR=/usr/share/voikko

FROM php:8-fpm-buster
RUN apt-get update && apt-get install -y libffi-dev && docker-php-ext-install ffi
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && echo 'ffi.enable=true' >> "$PHP_INI_DIR/php.ini"
COPY --from=voikko /usr/lib/libvoikko.so* /usr/lib/
COPY --from=voikko /usr/share/voikko /usr/share/voikko
