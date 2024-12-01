<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConfigProc;

class ConfigProcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConfigProc::create([
            'nome_outorgado' => 'Fernando Fantinel',
            'cpf_outorgado' => '123.123.087-07',
            'end_outorgado' => 'Rua Teste, 520',
            'nome_testemunha' => 'Alexandre Silva',
            'cpf_testemunha' => '654.987.456-02',
            'end_testemunha' => 'Rua Joso, 654',
            'texto_poderes' => 'FINS E PODERES: O OUTORGANTE confere ao OUTORGADO amplos e ilimitados poderes para o fim
especial de vender a quem quiser, receber valores de venda, transferir para si próprio ou terceiros, em causa
própria, locar ou de qualquer forma alienar ou onerar o veículo de sua propriedade com as seguintes
características:',
            'texto_final' => 'Assinar requerimentos , com poderes também para requerer, junto aos CRVAS/DETRAN-RS, os processos
de 2ª vias de CRV/CRLV, Baixa Definitiva do veículo, Alterações de informações do veículo, Solicitar
DCPPO e CRLV digital e ATPV-E, fazer declaração de residência ,fazer alteração de informações no
veículo, fazer ocorrência policial de perca de documento do veículo, assinar termo de responsabilidade pela
não apresentaçãode placas e lacre, fazer troca de município ,receber valores por indenização de
Seguradoras ,Assinar contratos de. inclusão e instrumentos de liberação de Alienação e Reserva de
Domínio para si.- próprio ou terceiros, endossar documentos, usar o veículo em apreço, manejando o
mesmo, em qualquer parte do território nacional ou estrangeiro, ficando cível e criminalmente responsável
por qualquer acidente ou ocorrência, pagar taxas, multas e impostos, liberar e retirar o veículo de depósitos
do DETRAN CRD e DELEGACIAS DE POLICIA CIVIL, EPTC ,PRF E POLICIA FEDERAL,BRIGADA
MILITAR , POLICIAL RODOVIA ESTADUAL ,assinar termos de liberação dar declarações e finalmente, usar
e gozar do veículo como coisa sua e sem interferência ou autorização de outros, podendo ainda, requerer,
perante autoridade alfandegária ou aduaneira de País estrangeiro, licença ou permissão de turismo pelo
tempo e prazo que julgar conveniente, podendo substabelecer a presente no todo ou em parte O outorgante
pelo presente instrumento declara-se responsável pelo pagamento de multas e impostos do veículo acima
descrito e caracterizado, até a data da outorga do presente mandato. ESTA PROCURAÇÃO É
AUTORGADA EM CARÁTER IRREVOGAVEL E IRRETRATAVEL, SEM QUALQUER PRESTAÇÃO DE
CONTAS AO PROPRIETÁRIO E HERDEIROS E OUTROS, VISTO TER SIDO QUITADO O PREÇO DO
VALOR DE VENDA DA TABELA DA FIPE NESTA DATA AO PROPRIETÁRIO.',

        ]);
    }
}
