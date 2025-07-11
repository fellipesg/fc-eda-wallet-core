# Wallet Core + Balances Service

Este projeto implementa um sistema de microsserviços com:

1. **Wallet Core** (Go) - Gerencia transações e publica eventos no Kafka
2. **Balances Service** (Laravel) - Consome eventos do Kafka e expõe API de balances

## 🚀 Como executar

### 1. Subir todos os serviços
```bash
docker-compose up -d
```

Isso irá subir:
- **Wallet Core** (porta 8080)
- **Balances Service** (porta 3003)
- **MySQL** (porta 3306 - wallet, porta 3307 - balances)
- **Kafka** (porta 9092)
- **Zookeeper** (porta 2181)
- **Control Center** (porta 9021)

### 2. Verificar se tudo está rodando
```bash
docker-compose ps
```

### 3. Executar migrations e seeders (automático)
O Laravel irá executar automaticamente as migrations e seeders quando subir.

## 📊 Endpoints disponíveis

### Wallet Core (porta 8080)
- `POST /clients` - Criar cliente
- `POST /accounts` - Criar conta
- `POST /transactions` - Criar transação

### Balances Service (porta 3003)
- `GET /api/balances/{account_id}` - Consultar balance de uma conta

## 🧪 Testando

### 1. Testar Wallet Core
```bash
# Criar cliente
curl -X POST http://localhost:8080/clients \
  -H "Content-Type: application/json" \
  -d '{"name": "João Silva", "email": "joao@email.com"}'

# Criar conta
curl -X POST http://localhost:8080/accounts \
  -H "Content-Type: application/json" \
  -d '{"client_id": "client-id-aqui"}'

# Criar transação
curl -X POST http://localhost:8080/transactions \
  -H "Content-Type: application/json" \
  -d '{"account_id_from": "account-1", "account_id_to": "account-2", "amount": 50}'
```

### 2. Testar Balances Service
```bash
# Consultar balance
curl http://localhost:3003/api/balances/account-1
```

### 3. Usar arquivos .http
- `api/client.http` - Para testar Wallet Core
- `balances-service/api/client.http` - Para testar Balances Service

## 🔄 Fluxo de dados

1. **Wallet Core** processa transações
2. **Wallet Core** publica eventos `BalanceUpdated` no Kafka
3. **Balances Service** consome eventos do Kafka
4. **Balances Service** atualiza seu banco de dados
5. **Balances Service** expõe API para consultar balances

## 📁 Estrutura do projeto

```
├── cmd/walletcore/          # Wallet Core (Go)
├── internal/                # Código interno do Wallet Core
├── balances-service/        # Balances Service (Laravel)
│   ├── app/                # Código da aplicação Laravel
│   ├── database/           # Migrations e seeders
│   ├── routes/             # Rotas da API
│   └── api/client.http     # Requests de teste
├── api/client.http         # Requests de teste do Wallet Core
└── docker-compose.yaml     # Configuração dos containers
```

## 🐛 Troubleshooting

### Se o Laravel não subir
```bash
# Verificar logs
docker-compose logs balances-app

# Executar migrations manualmente
docker-compose exec balances-app php artisan migrate --force
```

### Se o Kafka consumer não funcionar
```bash
# Verificar logs
docker-compose logs balances-kafka-consumer

# Verificar se o Kafka está rodando
docker-compose logs kafka
```

### Se as portas estiverem ocupadas
```bash
# Parar todos os containers
docker-compose down

# Remover volumes (cuidado: isso apaga os dados)
docker-compose down -v
```

## 📝 Dados de exemplo

Após subir o sistema, você terá:

### Contas pré-criadas:
- `account-1`: R$ 150,00
- `account-2`: R$ 250,00
- `e2a9ed94-18fc-41a7-8eb4-d7c5e155576d`: R$ 100,00
- `aed5db83-1a6e-465b-bb12-e95361d25d1a`: R$ 200,00

### Testar:
```bash
curl http://localhost:3003/api/balances/account-1
# Resposta: {"account_id":"account-1","balance":150.00}
``` 