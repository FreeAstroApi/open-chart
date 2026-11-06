# Open Chart on Cloudflare

Staging: https://open-chart.gabriel-naulleau.workers.dev

`npm run build:vinext` builds the Worker. `npm run start:vinext` previews it locally. The standard Next.js scripts remain available.

Provide the existing server environment variables through Cloudflare secret bindings. `.dev.vars` supplies local values; `.env.production.local` supplies build-time public configuration. Keep both files and any secrets JSON outside Git.

The existing Node test runner uses a separate Vitest config so the Cloudflare runtime plugin does not change test execution. The Vite/Vitest development dependencies are compatible with the migration toolchain.

The staging homepage, geo search, and an example natal calculation returned 200. Server secrets were scanned against built client assets and were absent. Application and Workers type checks and added-file lint pass. Production domain routing and Git build integration remain pending; keep Vercel until those are verified.
