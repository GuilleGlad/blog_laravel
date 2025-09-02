import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', 
                'resources/js/app.js',
                'resources/css/base/css/footer.css',
                'resources/css/base/css/general.css',
                'resources/css/base/css/menu.css',
                'resources/css/login/css/login.css',
                'resources/css/login/css/reset.css',
                'resources/css/manage_post/categories/css/article_category.css',
                'resources/css/manage_post/comments/css/comments.css',
                'resources/css/manage_post/post/css/article_show.css',
                'resources/css/user/css/syle_user.css',
                'resources/css/user/profiles/css/article_profile.css',
                'resources/css/user/profiles/css/style_profile.css',
            ],
            refresh: true,
        }),
    ],
    resolve:{
        alias:{
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    }    
});