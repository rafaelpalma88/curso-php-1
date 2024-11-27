<?php

class ProductRepository
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function coffeeOptions(): array
  {

    $sql1 = "SELECT * FROM produtos WHERE tipo = 'Café' ORDER BY preco";
    $statement = $this->pdo->query($sql1);
    $produtosCafe = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dadosCafe = array_map(function ($cafe) {
      return new Product(
        $cafe['id'],
        $cafe['tipo'],
        $cafe['nome'],
        $cafe['descricao'],
        $cafe['imagem'],
        $cafe['preco']
      );
    }, $produtosCafe);

    return $dadosCafe;

  }
  public function lunchOptions(): array
  {

    $sql1 = "SELECT * FROM produtos WHERE tipo = 'Almoco' ORDER BY preco";
    $statement = $this->pdo->query($sql1);
    $produtosAlmoco = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dadosAlmoco = array_map(function ($cafe) {
      return new Product(
        $cafe['id'],
        $cafe['tipo'],
        $cafe['nome'],
        $cafe['descricao'],
        $cafe['imagem'],
        $cafe['preco']
      );
    }, $produtosAlmoco);

    return $dadosAlmoco;

  }
  public function allOptions(): array
  {

    $sql3 = "SELECT * FROM produtos ORDER BY preco";
    $statement = $this->pdo->query($sql3);
    $produtosAll = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dadosAll = array_map(function ($cafe) {
      return new Product(
        $cafe['id'],
        $cafe['tipo'],
        $cafe['nome'],
        $cafe['descricao'],
        $cafe['imagem'],
        $cafe['preco']
      );
    }, $produtosAll);

    return $dadosAll;

  }
}

