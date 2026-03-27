<?php

$roles = ['talent', 'mentor', 'atasan', 'pdc_admin'];

foreach ($roles as $role) {
    $file = __DIR__ . "/resources/views/{$role}/profile.blade.php";
    if (file_exists($file)) {
        $content = file_get_contents($file);

        // Fix Desktop layout
        $content = preg_replace(
            "/if \\\(\\\$field\['key'\] === 'role_id'\\\) \{\s*\\\$optName = \\\$opt->role_name;\s*\} elseif/s",
            "if (\\\$field['key'] === 'role_id') {\n                                                            \\\$optName = ucwords(str_replace('_', ' ', \\\$opt->role_name));\n                                                        } elseif",
            $content
        );

        // Fix Mobile layout
        $content = preg_replace(
            "/if \\\(\\\$field\['key'\] === 'role_id'\\\) \\\$optName = \\\$opt->role_name;\s*elseif/s",
            "if (\\\$field['key'] === 'role_id') \\\$optName = ucwords(str_replace('_', ' ', \\\$opt->role_name));\n                                                        elseif",
            $content
        );

        file_put_contents($file, $content);
        echo "Fixed role options for $role\n";
    }
}
