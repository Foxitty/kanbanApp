# Kanban App - Sistema de Gerenciamento de Tarefas

Um aplicativo Kanban desenvolvido em Laravel para gerenciar tarefas e projetos de forma visual e organizada.

## 🚀 Sobre o Projeto

Este é um sistema de quadro Kanban que permite:

- **Gerenciar Quadros**: Crie quadros personalizados para diferentes projetos
- **Organizar em Colunas**: Estruture seu fluxo de trabalho com colunas personalizadas
- **Gerenciar Tarefas**: Crie cards com títulos, descrições e cores diferentes
- **Comentários**: Adicione comentários e respostas em threads nas tarefas
- **Arrastar e Soltar**: Reorganize tarefas e colunas intuitivamente
- **Autenticação**: Sistema de login e registro completo

## 🛠️ Tecnologias Utilizadas

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Bootstrap 5
- **JavaScript**: SortableJS para interatividade
- **Banco de Dados**: PostgreSQL
- **Containerização**: Docker + Laravel Sail

## 📋 Requisitos

- Docker
- Docker Compose
- Git

## 🚀 Instalação e Execução

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd kanban-app
```

### 2. Configure o ambiente

Copie o arquivo de exemplo de configuração:

```bash
cp .env.example .env
```

### 3. Configure o banco de dados

No arquivo `.env`, ajuste as configurações do PostgreSQL:

```env
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=kanban_app
DB_USERNAME=sail
DB_PASSWORD=password
```

### 4. Instale as dependências

```bash
# Instale as dependências PHP
./vendor/bin/sail composer install

# Instale as dependências JavaScript
./vendor/bin/sail npm install
```

### 5. Inicie o ambiente com Laravel Sail

**Laravel Sail** é uma camada de abstração que permite rodar o Laravel em containers Docker sem necessidade de configurar PHP, PostgreSQL, Redis, etc. localmente.

```bash
# Inicie os containers (PHP, PostgreSQL, Redis, etc.)
./vendor/bin/sail up -d
```

### 6. Configure o banco de dados

```bash
# Gere a chave da aplicação
./vendor/bin/sail artisan key:generate

# Execute as migrations (cria as tabelas no banco de dados)
./vendor/bin/sail artisan migrate
```

### 7. Compile e Inicie o servidor

```bash

# Compile os assets (IMPORTANTE: necessário para o funcionamento do frontend)
./vendor/bin/sail npm run build

# Inicie o servidor de desenvolvimento
./vendor/bin/sail artisan serve
```

### 8. Acesse a aplicação

Abra seu navegador e acesse: [http://localhost](http://localhost)

## 📖 Comandos Úteis do Sail

```bash
# Parar os containers
./vendor/bin/sail stop

# Reiniciar os containers
./vendor/bin/sail restart

# Acessar o terminal do container
./vendor/bin/sail shell

# Executar comandos Artisan
./vendor/bin/sail artisan migrate

# Executar comandos Composer
./vendor/bin/sail composer require vendor/package

# Executar comandos NPM
./vendor/bin/sail npm run dev

# Ver logs dos containers
./vendor/bin/sail logs

# Limpar cache
./vendor/bin/sail artisan cache:clear
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear
```

## 🏗️ Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/     # Controladores da aplicação
│   ├── Models/               # Modelos Eloquent
│   └── Providers/            # Providers do Laravel
├── resources/
│   ├── views/                # Templates Blade
│   │   ├── kanban/           # Views do Kanban
│   │   └── auth/             # Views de autenticação
│   └── js/                   # Arquivos JavaScript
├── routes/                   # Rotas da aplicação
├── database/
│   ├── migrations/           # Migrations do banco de dados
│   └── seeders/              # Seeders de dados
└── public/                   # Arquivos estáticos
```

## 📊 Modelos de Dados

### Board (Quadro)
- Nome
- Slug (URL amigável)
- Usuário proprietário

### Category (Coluna)
- Nome
- Cor
- Posição
- Relacionamento com Board

### Task (Tarefa/Card)
- Título
- Descrição
- Cor
- Posição
- Usuário criador
- Relacionamento com Category

### Comment (Comentário)
- Conteúdo
- Usuário criador
- Relacionamento com Task
- Respostas (threads)

## 🔧 Personalização

### Cores das Tarefas
O sistema utiliza uma paleta de cores predefinida. Você pode modificar no arquivo JavaScript:

```javascript
const palette = ['#6366f1', '#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#f97316', '#06b6d4', '#4b5563'];
```

### Estilos
Os estilos principais estão em:
- `resources/css/app.css` - Estilos base
- `tailwind.config.js` - Configuração do Tailwind CSS (para componentes do Laravel Breeze)
- `resources/views/layouts/app.blade.php` - Estilos personalizados do Bootstrap
