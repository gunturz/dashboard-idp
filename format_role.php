<?php

$roles = ['talent', 'mentor', 'atasan', 'pdc_admin'];

foreach ($roles as $role) {
    $file = __DIR__ . "/resources/views/{$role}/profile.blade.php";
    if (file_exists($file)) {
        $content = file_get_contents($file);

        // 1. In the profile text field value definition for Desktop & Mobile layout (it uses the same $profilFields array)
        // From: 'val' => $user->role->role_name ?? '-'
        // To:   'val' => ucwords(str_replace('_', ' ', $user->role->role_name ?? '-'))
        $content = preg_replace(
            "/'val' => \\\$user->role->role_name \?\? '-']/",
            "'val' => ucwords(str_replace('_', ' ', \\\$user->role->role_name ?? '-'))]",
            $content
        );

        // 2. In the dropdown option name logic
        // From: if ($field['key'] === 'role_id') $optName = $opt->role_name;
        // To:   if ($field['key'] === 'role_id') $optName = ucwords(str_replace('_', ' ', $opt->role_name));
        $content = preg_replace(
            "/if \\\(\\\$field\['key'\] === 'role_id'\\\) \\\$optName = \\\$opt->role_name;/",
            "if (\\\$field['key'] === 'role_id') \\\$optName = ucwords(str_replace('_', ' ', \\\$opt->role_name));",
            $content
        );
        
        // Let's also handle the multiline version of the condition (which might be in Desktop layout)
        $content = preg_replace(
            "/if \\\(\\\$field\['key'\] === 'role_id'\\\) \{\s*\\\$optName = \\\$opt->role_name;\s*\}/s",
            "if (\\\$field['key'] === 'role_id') {\n                                                            \\\$optName = ucwords(str_replace('_', ' ', \\\$opt->role_name));\n                                                        }",
            $content
        );

        file_put_contents($file, $content);
        echo "Updated $role\n";
    }
}
