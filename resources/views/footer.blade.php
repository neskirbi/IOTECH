<!-- ============================================================
     DETECCIÓN DE DOMINIO PARA TEMAS
     ============================================================ -->
@php
    $isKeySecure = isKeySecure();
@endphp

<footer class="main-footer border-top-0 text-muted" style="background-color: var(--bg-card); font-size: 0.85rem;">
    <div class="float-right d-none d-sm-inline">
        @if($isKeySecure)
            KeySecure AI Platform
        @else
            OIIon Security Platform
        @endif
    </div>
    
    @if($isKeySecure)
        <strong>
            <span style="color: var(--text-muted);">Powered by</span>
            <a href="https://oii-on.com" target="_blank" style="color: var(--accent-cyan); font-weight: 700; text-decoration: none;">
                OIIon
            </a>
        </strong>
        <span style="color: var(--text-muted);"> - Tecnología en seguridad</span>
    @else
        <strong>
            <a href="https://oii-on.com" target="_blank" style="color: var(--accent-cyan); text-decoration: none;">
                Copyright &copy; OIIon.
            </a>
        </strong>
        Todos los derechos reservados.
    @endif
</footer>