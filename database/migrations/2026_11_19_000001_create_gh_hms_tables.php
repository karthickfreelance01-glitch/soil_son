<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the Hospital Management (HMS) tables with exactly the same columns
 * as gh.hms-society.com (database/sql/gh_hms_schema.sql, taken from
 * hmssocie_gh_software_fixed.sql). Structure only — no patient data.
 *
 * Tables that already exist are skipped, so it is safe if you imported the
 * gh SQL file into this database yourself.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach ($this->tables() as $table => $statements) {
            if (Schema::hasTable($table)) {
                continue;
            }
            foreach ($statements as $sql) {
                DB::unprepared($sql);
            }
        }
    }

    public function down(): void
    {
        // Never drop hospital tables automatically — they hold patient records.
    }

    /** @return array<string, string[]> table => [CREATE, ALTER...] */
    protected function tables(): array
    {
        $sql = file_get_contents(database_path('sql/gh_hms_schema.sql'));
        $out = [];
        foreach (preg_split('/^-- TABLE: /m', $sql) as $chunk) {
            if (! preg_match('/^(\w+)\s*\n(.*)$/s', $chunk, $m)) {
                continue;
            }
            $statements = array_filter(array_map('trim', preg_split('/;\s*\n/', $m[2])));
            $out[$m[1]] = array_values(array_filter($statements, fn ($s) => $s !== '' && ! str_starts_with($s, '--')));
        }
        return $out;
    }
};
