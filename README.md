
# PROJETO GAMEHUB

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local.


## 📋 Pré-requisitos

Você precisará ter instalado na sua maquina:

```bash
  • Docker e Docker compose  
  • Node.js e NPM
  • Git
  • PHP 8+ e Composer
```
    
## 🔧 Instalação - Back-End

### 1. Clonando o projeto

• Execute o comando no seu terminal e clone o repositório:

```bash
  $ git clone https://github.com/DaviSouzaES/GAME-HUB-ES.git 
```

• Entre na pasta do projeto

```bash
  $ cd GAME-HUB-ES
```

### 2. Preparando as dependências

• Entre na pasta gamehub-api

```bash
  $ cd gamehub-api
```

• Instale as dependências

```bash
  $ composer install
```

### 3. Ambiente de desenvolvimento

• Construir e rodar os containers:

```bash
  // Abra o seu docker desktop
```

```bash
  (Rode no path do docker-compose.yml)    
  $ npm run start:docker
```

• Rode as migrations:

```bash
  $ php artisan migrate
```

• Iniciar servidor Back-End:

```bash    
  $ php artisan serve
```

• Resultado:

```bash
  INFO  Server running on [http://127.0.0.1:8000].
```

## 🔧 Instalação - Front-Env Vue

### 1. Preparando as dependências

• No diretório raiz, entre na pasta CLIENT

```bash
  $ cd client
```

• Instale as dependências

```bash
  $ npm install
```

### 2. Ambiente de desenvolvimento

• Inicie o servidor front-end Vue

```bash
  $ npm run serve
```

• Resultado:

```bash
  > client@0.1.0 serve
  > vue-cli-service serve

 INFO  Starting development server...
```

• Aguarde o build do projeto, ao terminar, acesse no seu navegador:

  - Local:   http://localhost:8080/
  - Network: http://192.168.0.103:8080/

## 🛠️ Construído com

* [Vue.js](https://vuejs.org) - O framework web usado;
* [Laravel](https://laravel.com) - O framework back-end usado;
* [NPM](https://www.npmjs.com) - Gerente de Dependência;
* [Composer](https://getcomposer.org) - Gerente de Dependência;
* [RAWG Video Games Database API](https://api.rawg.io/docs/)) - API de dados.


## Features para implementar

* Botão de editar as informações do usuário;
* Paginação dos jogos comprados e com like;
* Aplicar animações e efeitos em todas as telas;
* Melhorar o tratamento de erros;
* Padronizar todo o código.

## ✒️ Autores

* **Davi Souza** - *Desenvolvimento Completo* - [Davi Souza](https://www.linkedin.com/in/davi-souza-745155246/)

## 📄 Licença

- [MIT](https://choosealicense.com/licenses/mit/)

- *O uso da RAWG Video Games Database API deve ser respeitada de acordo com os termos e condições de uso, provido pela [RAWG](https://api.rawg.io/docs/)*


---

![linkedin](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)

