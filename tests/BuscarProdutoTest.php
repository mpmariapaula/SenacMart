<?php
use PHPUnit\Framework\TestCase;

class BuscarProdutoTest extends TestCase
{
    private $originalIncludePath;

    protected function setUp(): void
    {
        $this->originalIncludePath = get_include_path();
        set_include_path(__DIR__);
    }

    protected function tearDown(): void
    {
        set_include_path($this->originalIncludePath);
        unset($_GET['busca'], $GLOBALS['__TEST_PRODUCT__']);
    }

    private function executarScript(): array
    {
        ob_start();
        include __DIR__ . '/../buscar_produto.php';
        return json_decode(ob_get_clean(), true);
    }

    public function testRetornaDadosJsonParaCodigoExistente(): void
    {
        $produto = ['codigo' => '123', 'nome' => 'Produto Teste'];
        $GLOBALS['__TEST_PRODUCT__'] = $produto;
        $_GET['busca'] = '123';

        $dados = $this->executarScript();
        $this->assertSame($produto, $dados);
    }

    public function testRetornaErroQuandoProdutoNaoEncontrado(): void
    {
        $GLOBALS['__TEST_PRODUCT__'] = null;
        $_GET['busca'] = '999';

        $dados = $this->executarScript();
        $this->assertSame('Produto não encontrado.', $dados['erro']);
    }
}

