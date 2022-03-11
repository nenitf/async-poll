# Para quem vai desenvolver

Documentação de apoio com comandos, dicas e referências.

## Lumen

- Cadastrar relação de interface x implementação no container no arquivo `app/Providers/AppServiceProvider`

### Migrations

- Gera migration limpa
    ```sh
    docker-compose exec app php artisan make:migration cria_livros
    ```

- Gera migration com template de criação de tabela
    ```sh
    docker-compose exec app php artisan make:migration cria_produtos --create=produtos
    ```

- Gera migration com template de modificação de tabela
    ```sh
    docker-compose exec app php artisan make:migration renomeia_produtos_artigos --table=produtos
    ```

- Exibe status
    ```sh
    docker-compose exec app php artisan migrate:status
    ```

- Atualiza até a ultima migration
    ```sh
    docker-compose exec app php artisan migrate
    ```

- Rollback
    ```sh
    docker-compose exec app php artisan migrate:rollback
    ```

- Atualiza até a ultima migration com seeds
    ```sh
    docker-compose exec app php artisan migrate --seed
    ```

- Reseta migrations (perde dados)
    ```sh
    docker-compose exec app php artisan migrate:reset
    ```

- Reseta migrations (perde dados) com seeds
    ```sh
    docker-compose exec app php artisan migrate:refresh --seed
    ```

- Reutiliza seeds
    ```sh
    docker-compose exec app php artisan db:seed
    ```

#### Apagar migration

- Caso **NÃO** tenha usado ``php artisan migrate``
    1. Apagar arquivo de migration
    2. Atualizar autoload ``composer du``

- Caso tenha usado php artisan migrate
    1. Voltar até a última migration correta com ``php artisan rollback``
    2. Apagar arquivo de migration
    3. Atualizar autoload ``composer du``

## PostgreSQL

- Acessar banco pelo terminal
    ```sh
    docker-compose exec db psql -U asyncpoll_user -d asyncpoll
    ```
### Comandos do terminal

| Comando| Descrição|
|--|--|
| `\?` | exibe ajuda |
| `\q` | sai |
| `\l` | lista databases |
| `\c <databasename>` | conecta uma database |
| `\dt` | lista tables da database |
| `\d <tablename>` | descreve uma tabela |

## Testes

- Simples
    ```sh
    docker-compose exec app composer test tests/caminho/do/ExemploTest.php
    ```
    > Um método de um arquivo: ``docker-compose exec app composer test -- --filter testName$ tests/caminho/do/ExemploTest.php``

- TDD
    ```sh
    ./tdd
    ```

    > O script executa o teste simples anterior, aceitando argumentos como ``./tdd -- --filter testName$ tests/caminho/do/ExemploTest.php``. Sua diferença é que executa novamente com qualquer tecla

    > O script pode ser executado com o git bash no Windows

- CI
    ```sh
    docker-compose exec app composer ci
    ```
    > Dashboard de relatório de cobertura disponível em `_reports/coverage/index.html`

## Instruções

- Nomear teste com verbo no imperativo explicitando a intencionalidade do teste, evitar nomes como "deve fazer x". [Orientação do time do Spotify](https://github.com/spotify/should-up)
- Caso por algum motivo o teste esteja incompleto e isso deve ser evidente, utilize ``$this->markTestIncomplete();``
    - Para listar os testes incompletos utilize a flag ``--verbose``
- ``dd($var)`` e ``dump($var)`` são bem úteis para inspecionar o valor de uma variável. Utilize ``$var->getAttributes()`` caso seja uma model do Eloquent

### Testes e2e

- Para analisar o retorno de uma requisição adicione `->dump()` após a `->response`, exemplo:
    ```diff
    <?php
        $this
            ->json('GET', self::$ep)
            ->response
    +       ->dump()
            ->assertOk();
    ```

### Github Actions

- [Visualizador JUnit (relatório de testes)](https://codepen.io/nenitf/full/GREQZRd?url=https://raw.githubusercontent.com/nenitf/async-poll/gh-pages/phpunit-log.xml)
- [Visualizador Clover (relatório de cobertura)](https://codepen.io/nenitf/full/NWwYQoz?url=https://raw.githubusercontent.com/nenitf/async-poll/gh-pages/clover.xml)
- [Dashboard de cobertura](https://neni.dev/async-poll/coverage/dashboard.html)
- [Relatório de cobertura simplificado](https://neni.dev/async-poll/coverage.txt)
