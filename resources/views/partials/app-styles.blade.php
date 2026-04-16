<style>
    /* ===================== RESET & BASE ===================== */
    *, *::before, *::after { box-sizing: border-box; }

    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Inter', 'Manrope', system-ui, sans-serif;
        color: #1e2022;
        background: #f4f6f8;
        font-size: 14px;
        line-height: 1.5;
    }

    /* ===================== LAYOUT ===================== */
    .app-main {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .page-wrap {
        flex: 1;
        max-width: 1280px;
        width: 100%;
        margin: 0 auto;
        padding: 32px 28px 60px;
    }

    /* ===================== PAGE HEADER ===================== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .page-title {
        margin: 0;
        font-size: 26px;
        font-weight: 800;
        color: #1e2022;
        letter-spacing: -0.02em;
    }

    .page-subtitle {
        margin: 4px 0 0;
        color: #8a929e;
        font-size: 14px;
        font-weight: 400;
    }

    /* ===================== BUTTONS ===================== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 8px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: background 0.15s ease, box-shadow 0.15s ease, transform 0.1s ease;
        white-space: nowrap;
    }

    .btn:hover { transform: translateY(-1px); }
    .btn:active { transform: translateY(0); }

    /* Primary = teal */
    .btn-primary {
        background: #1a6b74;
        color: #fff;
        border-color: #1a6b74;
    }
    .btn-primary:hover {
        background: #155d66;
        box-shadow: 0 4px 12px rgba(26, 107, 116, 0.25);
    }

    /* Secondary = light gray */
    .btn-secondary {
        background: #fff;
        color: #374151;
        border-color: #d1d5db;
    }
    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #bcc1c9;
    }

    /* Warning */
    .btn-warning {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }
    .btn-warning:hover { background: #fde68a; }

    /* Danger */
    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border-color: #fca5a5;
    }
    .btn-danger:hover { background: #fecaca; }

    /* ===================== CARDS / PANELS ===================== */
    .card {
        background: #fff;
        border: 1px solid #e5e8eb;
        border-radius: 12px;
        padding: 20px 24px;
    }

    .panel {
        background: #fff;
        border: 1px solid #e5e8eb;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }

    /* ===================== STAT CARDS ===================== */
    .stat-grid {
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5e8eb;
        border-radius: 12px;
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .stat-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #8a929e;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e2022;
        letter-spacing: -0.02em;
        line-height: 1.1;
    }

    .stat-value.accent  { color: #ea580c; }
    .stat-value.success { color: #16a34a; }
    .stat-value.teal    { color: #1a6b74; }
    .stat-value.danger  { color: #dc2626; }
    .stat-value.money   { font-size: 22px; }

    /* ===================== FILTERS BAR ===================== */
    .filter-bar {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .filter-bar input[type="text"],
    .filter-bar select {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 8px 12px;
        background: #f9fafb;
        font-family: inherit;
        font-size: 13px;
        color: #374151;
        transition: border-color 0.15s, box-shadow 0.15s;
        height: 36px;
    }

    .filter-bar input[type="text"] { flex: 1; min-width: 220px; }

    .filter-bar input[type="text"]:focus,
    .filter-bar select:focus {
        outline: none;
        border-color: #1a6b74;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(26, 107, 116, 0.1);
    }

    /* ===================== TABLE ===================== */
    .table-wrap {
        border: 1px solid #e5e8eb;
        border-radius: 10px;
        overflow-x: auto;
        background: #fff;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 580px;
    }

    th {
        text-align: left;
        padding: 11px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #8a929e;
        background: #f9fafc;
        border-bottom: 1px solid #e5e8eb;
        white-space: nowrap;
    }

    td {
        padding: 13px 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
    }

    tr:last-child td { border-bottom: none; }

    tbody tr { transition: background 0.1s ease; }
    tbody tr:hover { background: #f9fbfc; }

    .td-link {
        color: #1a6b74;
        font-weight: 600;
        text-decoration: none;
    }
    .td-link:hover { text-decoration: underline; }

    /* ===================== STATUS BADGES ===================== */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
        letter-spacing: 0.03em;
        border: 1px solid transparent;
    }

    .badge-default  { background: #f3f4f6; color: #374151; border-color: #e5e7eb; }
    .badge-pending  { background: #fff7ed; color: #c2410c; border-color: #fed7aa; }
    .badge-nego     { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .badge-accepted { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
    .badge-rejected { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

    /* ===================== ACTION LINKS IN TABLE ===================== */
    .action-link {
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        margin-right: 10px;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        font-family: inherit;
    }
    .action-link:last-child { margin-right: 0; }
    .action-link.edit    { color: #1a6b74; }
    .action-link.history { color: #1a6b74; }
    .action-link.detail  { color: #1a6b74; }
    .action-link.delete  { color: #dc2626; }
    .action-link:hover   { text-decoration: underline; }

    /* ===================== FORMS ===================== */
    .form-section { padding: 0; }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .form-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #4b5563;
        margin-bottom: 7px;
    }

    .form-control,
    input[type="text"].form-control,
    input[type="number"].form-control,
    input[type="date"].form-control,
    select.form-control,
    textarea.form-control {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 10px 14px;
        background: #f9fafb;
        font-family: inherit;
        font-size: 14px;
        color: #1f2937;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
        appearance: auto;
    }

    .form-control:focus {
        outline: none;
        border-color: #1a6b74;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(26, 107, 116, 0.1);
    }

    .form-grid {
        display: grid;
        gap: 0 20px;
        grid-template-columns: repeat(2, 1fr);
    }

    .form-grid .field-full { grid-column: span 2; }

    @media (max-width: 720px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .field-full { grid-column: span 1; }
    }

    .form-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
        font-weight: 500;
    }

    .action-bar {
        display: flex;
        gap: 10px;
        padding-top: 20px;
        border-top: 1px solid #e5e8eb;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    /* ===================== ALERTS ===================== */
    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* ===================== EMPTY STATE ===================== */
    .empty-state {
        border: 1px dashed #d1d5db;
        border-radius: 10px;
        padding: 36px;
        text-align: center;
        color: #9ca3af;
        font-style: italic;
        background: #f9fafb;
        font-size: 13px;
    }

    /* ===================== SECTION TITLE ===================== */
    .section-title {
        margin: 0 0 16px;
        font-size: 15px;
        font-weight: 700;
        color: #1e2022;
    }

    /* ===================== CHIP / TAG ===================== */
    .chip {
        display: inline-flex;
        align-items: center;
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 12px;
        font-weight: 600;
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    /* ===================== PAGINATION ===================== */
    .pagination { margin-top: 16px; }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 960px) {
        .page-wrap { padding: 20px 16px 48px; }
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 480px) {
        .stat-grid { grid-template-columns: 1fr; }
        .action-bar { flex-direction: column; }
        .action-bar .btn { width: 100%; }
    }
</style>
