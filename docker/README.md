<p align="center"><a href="https://www.docker.com/" target="_blank"><img src="https://www.docker.com/wp-content/uploads/2023/08/logo-guide-logos-1.svg" width="400" alt="Docker Logo"></a></p>

### Dockerize PHP Application

- [Install Docker](https://docs.docker.com/engine/install/)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

### Configuration step for docker files

- cp docker/.env.dist docker/.env

### Docker commands (Makefile):

- make -C docker build-nc
- make -C docker up-d
- make -C docker down-v
- make -C docker start
- make -C docker stop

### GIT commands:
- git config --global user.email "you@example.com"
- git config --global user.name "Your Name"

### [Laravel install](https://laravel.com/docs/10.x):

- make -C docker app-bash
- composer create-project laravel/laravel:^10.0 laravel
- rm .gitignore
- shopt -s dotglob
- mv laravel/* .
- shopt -u dotglob

### [Symfony install](https://symfony.com/doc/current/setup.html):

##### via CLI:

- set INSTALL_SYMFONY_CLI to true before the build
- make -C docker app-bash
- symfony new symfony --version="6.4.*" --webapp

##### via composer:

- make -C docker app-bash
- composer create-project symfony/skeleton:"6.4.*" symfony

##### and:

- rm .gitignore
- shopt -s dotglob
- mv symfony/* .
- shopt -u dotglob
- rmdir symfony