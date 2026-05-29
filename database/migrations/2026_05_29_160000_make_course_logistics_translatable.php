<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private array $fields = ['duracao_total', 'formato', 'preco', 'material_gratis_texto', 'certificacao_gratis_texto'];

    public function up(): void
    {
        Schema::table('courses', function (Blueprint $t) {
            foreach ($this->fields as $f) {
                $t->text($f)->nullable()->change();
            }
        });

        // Wrap any existing single-language value into a per-locale JSON map.
        $default = DB::table('site_settings')->value('idioma_padrao') ?: 'en';
        foreach (DB::table('courses')->get() as $c) {
            $upd = [];
            foreach ($this->fields as $f) {
                $v = $c->$f;
                if ($v !== null && trim((string) $v) !== '' && ! str_starts_with(trim((string) $v), '{')) {
                    $upd[$f] = json_encode([$default => $v], JSON_UNESCAPED_UNICODE);
                }
            }
            if ($upd) {
                DB::table('courses')->where('id', $c->id)->update($upd);
            }
        }
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $t) {
            $t->string('duracao_total', 100)->nullable()->change();
            $t->string('formato', 100)->nullable()->change();
            $t->string('preco', 100)->nullable()->change();
            $t->string('material_gratis_texto', 180)->nullable()->change();
            $t->string('certificacao_gratis_texto', 180)->nullable()->change();
        });
    }
};
