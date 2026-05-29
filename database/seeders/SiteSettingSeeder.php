<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'nome_site'           => 'Gramma Institute',
                'titulo_site'         => 'Gramma Institute',
                'subtitulo_site'      => 'Instituto Internacional de Línguas',
                'descricao_site'      => 'Aprendizagem de idiomas com metodologia moderna e professores qualificados.',
                'email_institucional' => 'admin@grammainstitute.pro',
                'idioma_padrao'       => 'pt_BR',
                'idiomas_activos'     => ['pt_BR', 'en', 'es', 'he', 'el'],
                'texto_rodape'        => ['en' => '© ' . date('Y') . ' Gramma Institute. All rights reserved.'],
                'meta_title'          => 'Gramma Institute — Instituto Internacional de Línguas',
                'meta_description'    => 'Aprenda idiomas com metodologia moderna. Português, Inglês, Espanhol, Hebraico e Grego.',
                'smtp_encryption'     => 'tls',
                'smtp_from_name'      => 'Gramma Institute',
            ]
        );
    }
}
