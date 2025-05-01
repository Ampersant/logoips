**Logoips - test task from [Nova Gmbh](https://www.nova-web.de/)**

WP Bedrock + Sage Theme with Swiper

---

## Overview

This project combines [Bedrock](https://roots.io/bedrock/) and [Sage](https://roots.io/sage/) to create a modern, organized WordPress setup featuring a custom navigation inspired by [bedimcode/responsive-navigation-bar](https://github.com/bedimcode/responsive-navigation-bar). It integrates the [Swiper](https://swiperjs.com/) library for touch-enabled slides.

## Features

* **Bedrock** directory structure and environment management
* **Sage** theme development toolkit (Blade templating, asset build pipeline)
* **Responsive navigation** based on bedimcode’s design
* **Swiper** integration for and sliders
* Dockerized development environment with MySQL, PHP-FPM, and Nginx

## Prerequisites

* Docker & Docker Compose installed (version >= 20.10)
* A MySQL dump file placed in `docker/mysql-init/name_of_db.sql`
* A valid `.env` file in the project root

**can be provided on request**

## Getting Started

1. **Clone the repository**

   ```bash
   git clone https://github.com/Ampersant/logoips.git
   cd logoips
   ```

2. **Prepare environment files**

   * Place dump of MySQL in next folder:

     ```
     docker/mysql-init/
     ```
   * Insert a `.env` file in the project root.

3. **Start Docker containers**

   ```bash
   docker-compose up --build
   ```

After 
```
db-1   | 2025-05-01T22:36:36.404201Z 0 [System] [MY-010931] [Server] /usr/sbin/mysqld: ready for connections. Version: '8.0.42'  socket: '/var/run/mysqld/mysqld.sock'  port: 3306  MySQL Community Server - GPL.
```
You ready to go!

❗❗❗ *To avoid issues please wait a few extra minutes, till the DB is fully set up* 

5. **Access the site**

   * Frontend: [http://localhost:8080](http://localhost:8080)
   * Admin: [http://localhost:8080/wp/wp-admin](http://localhost:8080/wp/wp-admin) - credentials on request
   * Database: host `db`, user and password as configured in `.env`



### Custom Navigation

The navigation walker extends WordPress’s `Walker_Nav_Menu` to output a custom dropdown. Inspired by [bedimcode/responsive-navigation-bar](https://github.com/bedimcode/responsive-navigation-bar).

## Docker Configuration

* **Services**:

  * `app`: PHP-FPM container running Bedrock/Sage
  * `web`: Nginx reverse proxy
  * `db`: MySQL with initialization

* **Volumes**:

  * `./docker/mysql-init/:/docker-entrypoint-initdb.d`
  * `./web:/var/www/html`

* **Ports**:

  * `8080:80` for HTTP


*Thank you for attention!*
