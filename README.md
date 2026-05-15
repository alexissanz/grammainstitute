# Gramma Institute

**Sistema Laravel para Instituto Internacional de Línguas**

Sistema web moderno, seguro e profissional para o Gramma Institute — uma instituição internacional de ensino de idiomas. Inclui site público institucional, autenticação completa, painel administrativo com AdminLTE oficial, gestão de configurações, suporte multilíngue (pt_BR, en, es, he, el) e SMTP configurável.

---

## Stack Tecnológica

| Tecnologia | Versão |
|---|---|
| Laravel | 12.x |
| PHP | 8.2+ |
| MySQL | 8.x |
| AdminLTE | 3.2 (via jeroennoten/laravel-adminlte) |
| Bootstrap | 5.3 (site público) |
| Vite / NPM | 7.x / 11.x |
| Font Awesome | 6.5 |
| Google Fonts | Noto Sans, Noto Sans Hebrew |

---

## Funcionalidades

### Site Público
- Página inicial com hero, cursos, vantagens, metodologia, testemunhos e contacto
- Páginas: Sobre, Cursos, Metodologia, Contacto, Privacidade, Termos
- Suporte RTL para Hebraico
- Troca de idioma em tempo real

### Autenticação
- Login / Logout
- Recuperação de senha por email
- Reset de senha
- Sistema de roles: `admin` e `user`

### Painel Administrativo (AdminLTE)
- Dashboard com cards de informação
- Gestão completa de configurações do site
- Teste de email com SMTP configurável
- Gestão de idiomas
- Perfil do utilizador

### Multilíngue
- Idiomas: **pt_BR**, **en**, **es**, **he** (RTL), **el**
- Middleware `SetLocale` automático via sessão
- Ficheiros de tradução em `lang/[locale]/`
- Facilmente extensível para novos idiomas

### Segurança
- CSRF em todos os formulários
- Middleware `auth` e `admin`
- Form Requests com validação estrita
- Senhas com Hash Laravel (bcrypt)
- Uploads validados (tipo e tamanho)
- `.env` nunca versionado

---

## Requisitos

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18 + NPM
- MySQL 8.x
- MAMP / XAMPP / Servidor local

---

## Instalação Local

### 1. Clonar o repositório

```bash
git clone https://github.com/alexissanz/grammainstitute.git
cd grammainstitute
```

### 2. Instalar dependências

```bash
composer install
npm install
```

### 3. Configurar o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Edite o `.env` com os seus dados:

```env
APP_URL=http://localhost/grammainstitute/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_da_base_de_dados
DB_USERNAME=usuario_db
DB_PASSWORD=senha_db
```

### 4. Configurar MySQL

No phpMyAdmin ou linha de comando:

```sql
CREATE DATABASE `db_grammaao` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'user_dbgrammaao'@'localhost' IDENTIFIED BY 'user_dbgrammaao';
GRANT ALL PRIVILEGES ON `db_grammaao`.* TO 'user_dbgrammaao'@'localhost';
FLUSH PRIVILEGES;
```

### 5. Executar migrations e seeders

```bash
php artisan migrate --seed
```

### 6. Criar link de storage

```bash
php artisan storage:link
```

### 7. Compilar assets

```bash
npm run build
```

---

## Acesso de Administrador

| Campo | Valor |
|---|---|
| Email | admin@gmail.com |
| Senha | 123456789 |
| URL Login | `/login` |
| URL Dashboard | `/dashboard` |

---

## Idiomas

| Código | Idioma | Direção |
|---|---|---|
| `pt_BR` | Português (Brasil) | LTR |
| `en` | English | LTR |
| `es` | Español | LTR |
| `he` | עברית | **RTL** |
| `el` | Ελληνικά | LTR |

**Trocar idioma:** `/lang/{locale}` (ex: `/lang/en`, `/lang/he`)

---

## SMTP

Configure no painel: **Dashboard → Configurações do Site → SMTP**

As configurações são guardadas na base de dados e aplicadas dinamicamente.

**Testar:** Dashboard → Teste de Email

---

## Comandos Úteis

```bash
# Limpar caches
php artisan cache:clear && php artisan config:clear && php artisan view:clear

# Re-executar seeders
php artisan db:seed

# Ver rotas
php artisan route:list

# Criar link de storage
php artisan storage:link

# Compilar para produção
npm run build

# Modo desenvolvimento
npm run dev
```

---

## Estrutura de Rotas

### Site Público
```
GET /              → Início
GET /about         → Sobre
GET /courses       → Cursos
GET /methodology   → Metodologia
GET /contact       → Contacto
GET /privacy       → Privacidade
GET /terms         → Termos
GET /lang/{locale} → Trocar idioma
```

### Autenticação
```
GET  /login                → Login
POST /login                → Processar login
POST /logout               → Logout
GET  /forgot-password      → Recuperar senha
POST /forgot-password      → Enviar link
GET  /reset-password/{tok} → Redefinir senha
```

### Admin (autenticado + admin)
```
GET  /dashboard            → Painel
GET  /admin/settings       → Configurações
PUT  /admin/settings       → Guardar
GET  /admin/email-test     → Teste de email
POST /admin/email-test     → Enviar email
GET  /admin/languages      → Idiomas
```

---

## Autor

**Alexandre Cristóvão**
Email: alexandre.ccrz@gmail.com
GitHub: [alexissanz](https://github.com/alexissanz)

---

*Gramma Institute — Instituto Internacional de Línguas*
