# Vertu PHP

É uma ferramenta que tem o objetivo de analisar a qualidade de um código feito em PHP, calculando algumas métricas que representam a sua qualidade.

O nome Vertu PHP, vem do francês 'virtude', com pronuncia 'vert', dado que a virtude é algo que desejamos, é considerado o correto e o objetivo comum.

## Instalação

Por enquanto não contamos com um meio de instalação concreto, no final todo o projeto será disponibilizado em um arquivo PHAR, assim como é feito com o Composer e PHPUnit.

No momento, pode-se instalão, clonando o repositóro:
```
git clone https://github.com/leonardovilarinho/vertu-php.git
```

E instalando suas dependências:
```
composer install
```

## Configurando

Você pode personalizar o Vertu, adicionando o arquivo de configuração `.env`, nele você pode definir algumas opções:

```
# caminho do projeto a ser qualificado
PROJECT= /home/vagrant/php/phar/esquelete

# diretórios que não iremos verificar
EXCLUDE_DIR= vendor|tests

# extensões de arquivos que vamos analisar
EXTENSION= *.php

# quantidade de arquivos que irão aparecer no resultado,
# no caso, os 6 piores arquivos
RANKING= 6

# tipos de arquivos que você irá excluir do resultado
# dentre os tipos temos: file, class, abstract class e interface
OMIT= interface
```

## Executando

No momento atual, para executar a ferramenta, no diretório do VertuPHP execute:
```
php src/index.php run
```