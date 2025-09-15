# 📋 Sistema de Registro de Ponto – Laravel 12

Este projeto é um sistema completo para **gestão de funcionários, gestores e registro de ponto**, desenvolvido em **Laravel 12** com **PHP 8.3** e **MySQL 8**.

---

## 🚀 Funcionalidades

- ✅ Cadastro de **Administradores**
- ✅ Cadastro de **Funcionários (Employees)** vinculados a Administradores
- ✅ Registro de ponto (**Time Records**) com filtros por data, funcionário e gestor
- ✅ API REST com autenticação
- ✅ FormRequests para validação
- ✅ Testes automatizados (PHPUnit / Laravel Test)
- ✅ Integração com **ViaCEP** para buscar endereço pelo CEP

---

## 🗂️ Estrutura do Projeto

- **app/** – Código do Laravel (Controllers, Models, Services, etc.)
- **routes/** – Rotas Web (`web.php`) e API (`api.php`)
- **tests/** – Testes automatizados

---

## ⚙️ Tecnologias Utilizadas

- **PHP 8.3**
- **Laravel 12**
- **MySQL 8**
- **Composer**
- **PHPUnit para testes**

---

## 📝 Configuração do Ambiente

### 1️⃣ Pré-requisitos

- PHP 8.3
- Composer
- MySQL 8

### 2️⃣ Clonar o repositório

```bash
git clone https://seu-repositorio.git
cd seu-projeto
```

### 3️⃣ Instalar dependências

```bash
composer install
```

### 4️⃣ Criar o arquivo `.env`

```bash
cp .env.example .env
```

### 5️⃣ Configurar o `.env`

Exemplo:

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Gerar chave:

```bash
php artisan key:generate
```

### 6️⃣ Rodar migrations

```bash
php artisan migrate
```

Se quiser popular dados iniciais (seeders):

```bash
php artisan db:seed
```

---

## 📝 Rodando os Testes

```bash
php artisan test
```

Os testes estão em `tests/Feature`:

- `LoginTest` → Testa autenticação.
- `EmployeeCrudTest` → Testa CRUD de funcionários.
- `TimeRecordTest` → Testa registros de ponto.

---

## 🔑 Autenticação da API

- API endpoints ficam em `routes/api.php`.
- Autenticação via **token Bearer** ou **Laravel Sanctum** (conforme configurado no projeto).
- Inclua o token no header:

```http
Authorization: Bearer {token}
Accept: application/json
Content-Type: application/json
```

---

## 📡 Endpoints Principais

| Método | Rota                  | Descrição                         |
|--------|------------------------|-----------------------------------|
| POST   | /login                 | Login e geração de token          |
| GET    | /employees             | Listar funcionários               |
| POST   | /employees             | Criar funcionário                 |
| GET    | /time-records          | Listar registros de ponto         |
| POST   | /time-records          | Criar registro de ponto           |

---

## 📋 Exemplos de Requisições (API)

### Login

```bash
curl -X POST http://localhost/api/login   -H "Accept: application/json"   -H "Content-Type: application/json"   -d '{
    "email": "admin@example.com",
    "password": "senha123"
  }'
```

Retorno esperado (exemplo):

```json
{
  "token": "seu_token_aqui"
}
```

---

### Criar Funcionário

```bash
curl -X POST http://localhost/api/employees   -H "Authorization: Bearer seu_token_aqui"   -H "Accept: application/json"   -H "Content-Type: application/json"   -d '{
    "name": "José da Silva",
    "cpf": "123.456.789-00",
    "email": "jose@example.com",
    "password": "123123123",
    "password_confirmation": "123123123",
    "birthdate": "1990-01-01",
    "position": "Analista",
    "cep": "14780-240",
    "number": "454"
  }'
```

---

### Listar Registros de Ponto com Filtro

```bash
curl -X GET "http://localhost/api/time-records?start_date=2025-01-01&end_date=2025-01-31"   -H "Authorization: Bearer seu_token_aqui"   -H "Accept: application/json"
```

---

## 🔄 Fluxo de Funcionamento

1. **Administrador** se autentica via login.
2. **Administrador** cadastra funcionários.
3. Funcionários podem registrar pontos (**Time Records**).
4. Administrador visualiza relatórios com filtros.

---

## 📝 Licença

Este projeto é de uso interno/demonstrativo.  
Sinta-se à vontade para adaptar às suas necessidades.

---

## 🤝 Contribuindo

Pull requests são bem-vindos!  
Para mudanças maiores, abra uma issue primeiro para discutirmos.

---

## 👨‍💻 Autor

Desenvolvido por **Lucas Emmanuel** 🚀  
Com foco em **clean code**, **testes automatizados** e **arquitetura sólida**.
