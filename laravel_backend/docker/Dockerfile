FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    vim \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd ctype dom iconv intl opcache pdo xml mysqli

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# But wait, there's more! Let's add some Node.js flavor to the mix. Because why stick to one language when you can have them all?
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html

# Set working directory
WORKDIR /var/www/html/

EXPOSE 8000
EXPOSE 3000

USER $user
