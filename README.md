# Demo-Webservice-Back

1) Install
    - ` $ composer i `

2) lexik_jwt_authentication
    - Create a dir `jwt` in `config`
    - Create private and public Keys
       - ` $ openssl genrsa -out config/jwt/private.pem -aes256 4096 `
       - ` $ openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem `
       - Passphrase: 123456 -- to change, see .env
      
3) ORM
    - Create databases and fixtures
        - ` $ php bin/console doctrine:database:create `
        - ` $ php bin/console doctrine:migrations:migrate `
        - ` $ php bin/console doctrine:fixtures:load `
       
4) Run server
    - ` $ symfony server:start `
