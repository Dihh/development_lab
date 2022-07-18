from usuario import Usuario
from lance import Lance
from leilao import Leilao
from avaliador import Avaliador

dihh = Usuario('Dihh')
lance_dihh = Lance(dihh, 100.0)

dehh = Usuario('Dehh')
lance_dehh = Lance(dehh, 150.0)

leilao = Leilao('Celulares')
leilao.addLance(lance_dihh)
leilao.addLance(lance_dehh)

avaliador = Avaliador(leilao)
avaliador.avalia()

for lance in leilao.lances:
    print(f'{lance.usuario.nome}: {lance.valor}')


print(f'menor: {avaliador.menor} - maior: {avaliador.maior}')
