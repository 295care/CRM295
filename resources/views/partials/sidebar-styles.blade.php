<style>
    /* ===================== SIDEBAR SHELL ===================== */
    .app-shell {
        display: flex;
        min-height: 100vh;
    }

    /* ===================== SIDEBAR ===================== */
    .app-sidebar {
        width: 200px;
        flex-shrink: 0;
        background: #1a3a42;
        color: #cfe8e6;
        padding: 20px 14px;
        position: sticky;
        top: 0;
        height: 100vh;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: width 200ms ease, padding 200ms ease;
        overflow: hidden;
    }

    /* ===================== BRAND ===================== */
    .app-brand-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .app-brand {
        margin: 0;
        font-size: 17px;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.01em;
        white-space: nowrap;
    }

    .app-sidebar-toggle {
        flex-shrink: 0;
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 6px;
        background: rgba(255,255,255,0.08);
        color: #cfe8e6;
        font-size: 13px;
        font-weight: 700;
        width: 28px;
        height: 28px;
        cursor: pointer;
        transition: transform 180ms ease, background 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .app-sidebar-toggle:hover {
        background: rgba(255,255,255,0.15);
    }

    /* ===================== NAV ===================== */
    .app-nav {
        display: flex;
        flex-direction: column;
        gap: 4px;
        flex: 1;
    }

    .app-nav-link {
        display: block;
        text-decoration: none;
        color: #b0cdc9;
        border-radius: 7px;
        padding: 9px 12px;
        font-size: 13px;
        font-weight: 600;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .app-nav-link:hover {
        background: rgba(255,255,255,0.07);
        color: #e0f4f1;
    }

    .app-nav-link.active {
        background: rgba(255,255,255,0.13);
        color: #fff;
    }

    /* NAV GROUP */
    .app-nav-group {
        border-radius: 7px;
        overflow: hidden;
    }

    .app-nav-title {
        margin: 0;
        padding: 8px 12px 4px;
        font-size: 10px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #6b9e98;
        font-weight: 700;
    }

    .app-subnav {
        display: flex;
        flex-direction: column;
        gap: 2px;
        padding-bottom: 4px;
    }

    .app-subnav a {
        display: block;
        text-decoration: none;
        color: #b0cdc9;
        border-radius: 7px;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 600;
        transition: background 0.15s, color 0.15s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .app-subnav a:hover {
        background: rgba(255,255,255,0.07);
        color: #e0f4f1;
    }

    .app-subnav a.active {
        background: rgba(255,255,255,0.13);
        color: #fff;
    }

    /* ===================== FOOTER ===================== */
    .app-sidebar-footer {
        margin-top: auto;
        display: flex;
        flex-direction: column;
        gap: 6px;
        padding-top: 12px;
        border-top: 1px solid rgba(255,255,255,0.08);
    }

    .app-user-chip {
        border-radius: 7px;
        padding: 8px 11px;
        background: rgba(255,255,255,0.07);
        font-size: 12px;
        font-weight: 700;
        color: #c8e5e1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .app-logout-btn {
        width: 100%;
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 7px;
        padding: 8px 11px;
        font-size: 12px;
        font-weight: 600;
        font-family: inherit;
        color: #b0cdc9;
        cursor: pointer;
        background: transparent;
        text-align: center;
        transition: background 0.15s, color 0.15s;
    }

    .app-logout-btn:hover {
        background: rgba(255,255,255,0.08);
        color: #fff;
    }

    /* ===================== COLLAPSED STATE ===================== */
    .app-shell.sidebar-collapsed .app-sidebar {
        width: 56px;
        padding-inline: 10px;
    }

    .app-shell.sidebar-collapsed .app-brand-text,
    .app-shell.sidebar-collapsed .app-nav-title,
    .app-shell.sidebar-collapsed .app-subnav a span,
    .app-shell.sidebar-collapsed .app-user-chip,
    .app-shell.sidebar-collapsed .app-logout-btn {
        display: none;
    }

    .app-shell.sidebar-collapsed .app-sidebar-toggle {
        transform: rotate(180deg);
    }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 960px) {
        .app-shell { flex-direction: column; }

        .app-sidebar {
            position: static;
            height: auto;
            width: 100%;
            flex-direction: row;
            flex-wrap: wrap;
            padding: 12px 16px;
            gap: 8px;
        }

        .app-brand-row { border-bottom: none; padding-bottom: 0; }
        .app-nav { flex-direction: row; flex-wrap: wrap; gap: 4px; flex: none; }
        .app-subnav { flex-direction: row; }
        .app-sidebar-toggle { display: none; }
        .app-sidebar-footer { display: none; }
    }
</style>
