## ■ ローカル環境 仕様

- [PHP](https://www.php.net) Version 8.2.8

- [Composer](https://getcomposer.org) Version 2.5.8
  - [google/apiclient](https://packagist.org/packages/google/apiclient) Version 2.15.0

- [Docker](https://www.docker.com) Version 24.0.2
  - Docker Compose Version 2.19.1

#### ■ Docker Compose（compose.yaml） 定義

```Yaml
version: '3.8'

services:
  "サービス名":
  container_name: "コンテナ名"
  image: "Docker イメージ名"
  build:
    context: .
  volumes:
    - .:/usr/local/src:delegated
  deploy:
    resources:
      limits:
        cpus: '4.0'
        memory: 2gb
      reservations:
        cpus: '1.0'
        memory: 1gb
  tty: true
```

#### ■ Dockerfile 定義

- Dockerfile  
→ https://github.com/masakazu-hirano/PHP_Develop/blob/master/Dockerfile

- PHP で、Googleカレンダーからイベント取得  
→ https://github.com/masakazu-hirano/PHP_Develop/blob/master/GET_Calendar_Events.php

## ■ 課題（今後 やるべきこと）

- 環境変数 設定
  - [PHP dotenv](https://github.com/vlucas/phpdotenv) を使用して、環境変数を設定・管理
 
  - PHP で、日時取得の方法
 
  - 取得したイベントを通知するサービス選定
