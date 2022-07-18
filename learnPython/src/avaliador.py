import sys
from leilao import Leilao
from lance import Lance


class Avaliador:
    def __init__(self, leilao: Leilao):
        self.__leilao = leilao
        self.__menor = sys.float_info.max
        self.__maior = sys.float_info.min

    @property
    def menor(self):
        return self.__menor

    @property
    def maior(self):
        return self.__maior

    def avalia(self):
        for lance in self.__leilao.lances:
            if self.__maior < lance.valor:
                self.__maior = lance.valor
            if self.__menor > lance.valor:
                self.__menor = lance.valor
