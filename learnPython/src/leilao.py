class Leilao:
    def __init__(self, produto):
        self.__produto = produto
        self.__lances = []

    @property
    def produto(self):
        return self.__produto

    @produto.setter
    def produto(self, produto):
        self.__produto = produto

    @property
    def lances(self):
        return self.__lances

    def addLance(self, lance):
        self.__lances.append(lance)
