# Open Chart on Cloudflare

Staging: https://open-chart.gabriel-naulleau.workers.dev

`npm run build:vinext` builds the Worker. `npm run start:vinext` previews it locally. The standard Next.js scripts remain available.

Provide the existing server environment variables through Cloudflare secret bindings. `.dev.vars` supplies local values; `.env.production.local` supplies build-time public configuration. Keep both files and any secrets JSON outside Git.

The existing Node test runner uses a separate Vitest config so the Cloudflare runtime plugin does not change test execution. The Vite/Vitest development dependencies are compatible with the migration toolchain.

The staging homepage, geo search, and an example natal calculation returned 200. Server secrets were scanned against built client assets and were absent. Application and Workers type checks and added-file lint pass.

Workers Builds is connected to `FreeAstroApi/open-chart` and deploys from `main`. The build command is `npm run build:vinext` and the deploy command is `npx cf deploy --prebuilt`; preview builds are disabled. The existing `FREE_ASTRO_API_KEY` remains an encrypted Worker secret.
