# AI Collaborator Project Plan

This document outlines a high level plan for bringing AI-assisted writing and collaboration to BookStack. It draws from discussions about leveraging the TinyMCE editor plugin system, existing search indexing and real-time collaboration features.

## Goals

* Provide an in-editor conversational assistant that can help generate, edit and brainstorm text.
* Allow semantic searching across all page, chapter and book content using embeddings.
* Integrate with external AI services while keeping configuration secure via BookStack settings.
* Support collaborative editing where the AI acts as another participant via Yjs real-time sync.

## Overview

The plan builds on existing code components:

* **Editor plugins** – Plugins are registered in `resources/js/wysiwyg-tinymce/config.js` via `window.tinymce.PluginManager.add()`【F:resources/js/wysiwyg-tinymce/config.js†L110-L150】.
* **HTTP requests** – Outbound calls are handled through `HttpRequestService`【F:app/Http/HttpRequestService.php†L20-L34】.
* **Settings** – Persistent configuration is stored via `SettingService`【F:app/Services/SettingService.php†L168-L181】.
* **Real-time collaboration** – Yjs modules under `resources/js/wysiwyg/lexical/yjs/` provide multiuser editing.

## Implementation Phases

1. **Editor Plugin**
   - Create `resources/js/wysiwyg-tinymce/plugins/ai-collaborator.js`.
   - Add the plugin to the list returned by `gatherPlugins()`.
   - Provide a sidebar chat UI where users can interact with the AI and insert text into the editor.

2. **Backend Controller & Routes**
   - Add `AiCollaboratorController` in `app/Http/Controllers` with endpoints for chat and text generation.
   - Use `HttpRequestService` to call the selected AI provider.
   - Register API/AJAX routes under `routes/web.php` or `routes/api.php`.

3. **Embedding Index**
   - Create a service `EmbeddingIndex` mirroring `SearchIndex::indexAllEntities` but sending text to an embedding API.
   - Store vectors in a new `text_embeddings` table. Add migrations under `database/migrations`.
   - Provide queries for cosine similarity search so the AI can reference related pages and chapters.

4. **Real-Time Integration**
   - Hook the AI plugin into the Yjs collaboration layer to allow the AI to insert text live.
   - Display the AI as another collaborator in the editor, using the existing Yjs cursor and state modules.

5. **Settings & Permissions**
   - Add a settings page (e.g., `resources/views/settings/categories/ai.blade.php`) for API keys and feature toggles.
   - Persist these settings using `SettingService`.
   - Add permissions so administrators can control who may use the AI features.

6. **Tool and RAG Support**
   - Provide endpoints for running external tools or retrieval-augmented generation flows.
   - Allow the AI plugin to trigger these operations through additional commands.

7. **Testing & QA**
   - Write unit and feature tests to cover new controllers and services.
   - Include JavaScript tests for the plugin UI where possible.

8. **Documentation**
   - Document setup, configuration and permissions in new docs under `docs/`.

## Todo List

1. [x] Create database migration for `text_embeddings` table.
2. [ ] Implement `EmbeddingIndex` service to create and query embeddings.
3. [ ] Build `AiCollaboratorController` with chat and generation endpoints.
4. [ ] Add `ai-collaborator.js` TinyMCE plugin with sidebar chat panel.
5. [ ] Register the plugin in `gatherPlugins()`.
6. [ ] Add settings page and storage for API keys and feature flags.
7. [ ] Wire up Yjs integration so AI edits appear as a collaborator.
8. [ ] Write feature tests for API endpoints and embedding search.
9. [ ] Document usage in `docs/` and update README with a short summary.

This plan should guide further development of AI-assisted bookwriting in BookStack.
