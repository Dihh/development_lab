class Lance:
    def __init__(self, usuario, valor):
        self.__usuario = usuario
        self.__valor = valor

    @property
    def usuario(self):
        return self.__usuario

    @usuario.setter
    def usuario(self, usuario):
        self.__usuario = usuario

    @property
    def valor(self):
        return self.__valor

    @valor.setter
    def valor(self, valor):
        self.__valor = valor
