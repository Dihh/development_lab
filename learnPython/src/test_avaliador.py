from unittest import TestCase
from usuario import Usuario
from lance import Lance
from leilao import Leilao
from avaliador import Avaliador


class testAvaliador(TestCase):
    def test_avaliador(self):
        dihh = Usuario('Dihh')
        lance_dihh = Lance(dihh, 100.0)

        dehh = Usuario('Dehh')
        lance_dehh = Lance(dehh, 150.0)

        leilao = Leilao('Celulares')
        leilao.addLance(lance_dihh)
        leilao.addLance(lance_dehh)

        avaliador = Avaliador(leilao)
        avaliador.avalia()

        self.assertEqual(100, avaliador.menor)
        self.assertEqual(150, avaliador.maior)
