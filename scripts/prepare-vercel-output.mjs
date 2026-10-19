import { cp, mkdir, rm } from 'node:fs/promises';
import { extname, relative, resolve, sep } from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = fileURLToPath(new URL('../', import.meta.url));
const publicDirectory = resolve(projectRoot, 'public');
const outputDirectory = resolve(projectRoot, 'vercel-public');

await rm(outputDirectory, { recursive: true, force: true });
await mkdir(outputDirectory, { recursive: true });
await cp(publicDirectory, outputDirectory, {
    recursive: true,
    filter(source) {
        const relativePath = relative(publicDirectory, source);

        if (!relativePath) {
            return true;
        }

        const pathParts = relativePath.split(sep);

        return !pathParts.includes('.htaccess')
            && !pathParts.some((part) => extname(part).toLowerCase() === '.php');
    },
});
