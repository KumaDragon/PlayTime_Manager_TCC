import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

// https://vitejs.dev/config/
export default defineConfig({
    root: 'resources', // ou a pasta que está a sua aplicação front-end
    build: {
        outDir: 'public', // O diretório de saída dos assets compilados
    },
    optimizeDeps: {
        include: ['some-package'], // Se necessário, adicione pacotes aqui
    },
    server: {
        proxy: {
            '/app': 'http://127.0.0.1',
        }
    }
});

