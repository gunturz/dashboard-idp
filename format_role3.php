<?php

$roles = ['talent', 'mentor', 'atasan', 'pdc_admin'];

foreach ($roles as $role) {
    $file = __DIR__ . "/resources/views/{$role}/profile.blade.php";
    if (file_exists($file)) {
        $content = file_get_contents($file);

        // Fix Desktop layout format (with braces)
        $search1 = "if (\$field['key'] === 'role_id') {\n                                                            \$optName = \$opt->role_name;\n                                                        } elseif";
        $replace1 = "if (\$field['key'] === 'role_id') {\n                                                            \$optName = ucwords(str_replace('_', ' ', \$opt->role_name));\n                                                        } elseif";
        $content = str_replace($search1, $replace1, $content);

        // Fix Mobile layout format (single line)
        $search2 = "if (\$field['key'] === 'role_id') \$optName = \$opt->role_name;\n                                                        elseif";
        $replace2 = "if (\$field['key'] === 'role_id') \$optName = ucwords(str_replace('_', ' ', \$opt->role_name));\n                                                        elseif";
        $content = str_replace($search2, $replace2, $content);

        file_put_contents($file, $content);
        echo "Fixed role options for str_replace $role\n";
    }
}
