<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private $leiloeiro;

    public function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    /**
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */

    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(1700, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(2000, $maiores[1]->getValor());
        static::assertEquals(1700, $maiores[2]->getValor());
    }

    public function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');
        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        return [
            'ordem-crescente' => [$leilao]
        ];
    }

    public function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat 147 0KM');
        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));
        return [
            'ordem-decrescente' => [$leilao]
        ];
    }

    public function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Fiat 147 0KM');
        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($maria, 2500));
        return [
            'ordem-aleatoria' => [$leilao]
        ];
    }
}
