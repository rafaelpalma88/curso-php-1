<?php

class ProductRepository
{
  private PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function createProductObj($dados): Product
  {
    return new Product(
      $dados['id'],
      $dados['tipo'],
      $dados['nome'],
      $dados['descricao'],
      $dados['preco'],
      $dados['imagem'],
    );
  }

  public function coffeeOptions(): array
  {

    $sql1 = "SELECT * FROM produtos WHERE tipo = 'Café' ORDER BY preco";
    $statement = $this->pdo->query($sql1);
    $produtosCafe = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dadosCafe = array_map(function ($cafe) {
      return $this->createProductObj($cafe);
    }, $produtosCafe);

    return $dadosCafe;

  }
  public function lunchOptions(): array
  {

    $sql1 = "SELECT * FROM produtos WHERE tipo = 'Almoco' ORDER BY preco";
    $statement = $this->pdo->query($sql1);
    $produtosAlmoco = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dadosAlmoco = array_map(function ($lunch) {
      return $this->createProductObj($lunch);
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
        $cafe['preco'],
        $cafe['imagem'],
      );
    }, $produtosAll);

    return $dadosAll;

  }
  public function removeItem(int $id): void
  {

    $sql4 = "DELETE FROM produtos WHERE id = ? LIMIT 1";
    $statement = $this->pdo->prepare($sql4);
    $statement->bindValue(1, $id);
    $statement->execute();

  }

  public function addItem($product): void
  {

    $sql5 = "INSERT INTO produtos (tipo, nome, descricao, preco, imagem) VALUES (?, ?, ?, ?, ?)";
    $statement = $this->pdo->prepare($sql5);
    $statement->bindValue(1, $product->getTipo());
    $statement->bindValue(2, $product->getNome());
    $statement->bindValue(3, $product->getDescricao());
    $statement->bindValue(4, $product->getPreco());
    $statement->bindValue(5, $product->getImagem());
    $statement->execute();

  }

  public function getItemById(int $productId): Product
  {

    $sql6 = "SELECT * FROM produtos WHERE id = ? LIMIT 1";
    $statement = $this->pdo->prepare($sql6);
    $statement->bindValue(1, $productId);
    $statement->execute();

    $dados = $statement->fetch(PDO::FETCH_ASSOC);

    return $this->createProductObj($dados);

  }
  public function updateItem($product): void
  {

    $sql7 = "UPDATE produtos SET tipo = ?, nome = ? , descricao = ?, preco = ? , imagem = ? WHERE id = ?";
    $statement = $this->pdo->prepare($sql7);
    $statement->bindValue(1, $product->getTipo());
    $statement->bindValue(2, $product->getNome());
    $statement->bindValue(3, $product->getDescricao());
    $statement->bindValue(4, $product->getPreco());
    $statement->bindValue(5, $product->getImagem());
    $statement->bindValue(6, $product->getId());
    $statement->execute();

    if ($product->getImagem() !== 'logo-serenatto.png') {

      $this->atualizarFoto($product);
    }

  }

  private function atualizarFoto(Product $product)
  {
    $sql = "UPDATE produtos SET imagem = ? WHERE id = ?";
    $statement = $this->pdo->prepare($sql);
    $statement->bindValue(1, $product->getImagem());
    $statement->bindValue(2, $product->getId());
    $statement->execute();
  }
}

