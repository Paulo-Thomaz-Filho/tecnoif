```markdown
# 🚀 TecnoIF - Soluções Tecnológicas

> Uma plataforma institucional com painel administrativo para gestão de contatos e serviços.

![Badge em Desenvolvimento](http://img.shields.io/static/v1?label=STATUS&message=CONCLUIDO&color=GREEN&style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)

## 💻 Sobre o Projeto

O **TecnoIF** é uma aplicação web desenvolvida para apresentar soluções tecnológicas (Gestão de Estoques, E-commerce, Blogs). O projeto conta com uma Landing Page moderna com tema "Neon" e uma área administrativa segura para gerenciamento de mensagens recebidas pelo formulário de contato.

O sistema foi construído utilizando o padrão de arquitetura **MVC (Model-View-Controller)** em PHP puro, garantindo organização, segurança e escalabilidade.

---

## ⚙️ Funcionalidades

### 🌐 Front-end (Público)
- **Navegação Spy Scroll:** Menu que identifica automaticamente a seção visível na tela.
- **Modais Interativos:** Detalhes dos serviços (Estoques, E-commerce, Blogs) sem recarregar a página.
- **Formulário com Validação:** Validação de CPF e CNPJ em tempo real via JavaScript antes do envio.
- **Design Responsivo:** Layout adaptável para dispositivos móveis e desktop utilizando Bootstrap 5.3.

### 🔒 Back-end (Administrativo)
- **Autenticação Segura:** Sistema de Login com verificação de hash de senha (`password_verify`).
- **Dashboard de Mensagens:** Visualização tabular de todos os contatos recebidos pelo site.
- **Rotas Amigáveis:** Sistema de roteamento próprio (ex: `/login`, `/admin`, `/home`) configurado via `.htaccess`.
- **Segurança:** Proteção contra SQL Injection (PDO prepared statements) e XSS (`htmlspecialchars`).

---

## 🛠️ Tecnologias Utilizadas

**Front-end:**
- HTML5 & CSS3 (Variáveis CSS, Flexbox, Grid)
- Bootstrap 5.3
- JavaScript & jQuery (AJAX para requisições assíncronas)

**Back-end:**
- PHP 7.4+ (Orientado a Objetos)
- MySQL (Banco de Dados)
- Apache (Reescrita de URL)

---

## 🚀 Como rodar o projeto localmente

### Pré-requisitos
Certifique-se de ter instalado:
- Um servidor local (XAMPP, WAMP ou Docker).
- PHP e MySQL.

### 1. Configuração do Banco de Dados
Crie um banco de dados e execute o seguinte script SQL para criar as tabelas necessárias e o usuário administrador padrão:

```sql
CREATE DATABASE talentos_tecnoif;
USE talentos_tecnoif;

-- Tabela de Administradores
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Tabela de Mensagens
CREATE TABLE mensagem (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    CpfCnpj VARCHAR(20) NOT NULL,
    Mensagem TEXT NOT NULL,
    DataEnvio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir usuário admin padrão (Senha: 123456)
INSERT INTO admin (nome, senha) VALUES ('admin', '$2y$10$Bib1p8W.I/s4.S6tXyqKZu.sZl.sZl.sZl.sZl.sZl.sZl');

```

### 2. Configuração da Conexão

1. Navegue até o arquivo `app/database/Database.php`.
2. Altere as credenciais para o seu ambiente local (nunca suba senhas reais para o GitHub):

```php
private $host = "localhost";
private $db_name = "talentos_tecnoif";
private $username = "root"; // Seu usuário local
private $password = "";     // Sua senha local

```

### 3. Executando

1. Coloque a pasta do projeto dentro do diretório do seu servidor (ex: `htdocs` no XAMPP).
2. Acesse no navegador: `http://localhost/nome-da-pasta/`.
3. Para acessar o painel administrativo:
* URL: `/login`
* **Usuário:** `admin`
* **Senha:** `123456`



---

## 📂 Estrutura de Pastas (MVC)

```
/
├── app/
│   ├── controllers/  # Lógica de controle (Login, Mensagens, Enviar)
│   ├── models/       # Modelos de Dados (Usuario, Mensagem)
│   ├── database/     # Conexão PDO (Database.php)
│   └── core/         # Gerenciador de Rotas (Router.php)
├── public/
│   ├── assets/       # CSS, JS, Imagens
│   └── views/        # Arquivos de visualização (HTML/PHP)
├── .htaccess         # Redirecionamento de rotas
└── index.php         # Ponto de entrada da aplicação

```

---

## 👥 Autores

<table>
<tr>
<td align="center"><a href="https://www.google.com/search?q=https://github.com/Paulo-Thomaz-Filho"><img style="border-radius: 50%;" src="https://www.google.com/search?q=https://avatars.githubusercontent.com/u/placeholder%3Fs%3D100" width="100px;" alt=""/><br /><sub><b>Paulo Thomaz</b></sub></a><br />Gerente de Projetos & Dev</td>
<td align="center"><a href="#"><img style="border-radius: 50%;" src="https://www.google.com/search?q=https://avatars.githubusercontent.com/u/placeholder%3Fs%3D100" width="100px;" alt=""/><br /><sub><b>Eduardo Nogueira</b></sub></a><br />Front-End</td>
<td align="center"><a href="#"><img style="border-radius: 50%;" src="https://www.google.com/search?q=https://avatars.githubusercontent.com/u/placeholder%3Fs%3D100" width="100px;" alt=""/><br /><sub><b>Henrico Santos</b></sub></a><br />Back-End</td>
<td align="center"><a href="#"><img style="border-radius: 50%;" src="https://www.google.com/search?q=https://avatars.githubusercontent.com/u/placeholder%3Fs%3D100" width="100px;" alt=""/><br /><sub><b>Jhonny Sancho</b></sub></a><br />Designer UX/UI</td>
<td align="center"><a href="#"><img style="border-radius: 50%;" src="https://www.google.com/search?q=https://avatars.githubusercontent.com/u/placeholder%3Fs%3D100" width="100px;" alt=""/><br /><sub><b>João Marcos</b></sub></a><br />Front-End</td>
</tr>
</table>

---

## 📝 Licença

Este projeto está sob a licença MIT.

```

```
