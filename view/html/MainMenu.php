<div class="br-logo"><a href=""><span>[</span>Titulos<span>]</span></a></div>

<div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-15 mg-t-20">Menu</label>
    <div class="br-sideleft-menu">

        <a href="../UsuPerfil" class="br-menu-link">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-person tx-20"></i>
                <span class="menu-item-label">Perfil</span>
            </div>
        </a>

        <a href="../UsuHome" class="br-menu-link">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-home tx-22"></i>
                <span class="menu-item-label">Inicio</span>
            </div>
        </a>

        <?php 
        if($_SESSION["usua_rol"] == 1){
            ?>
            <a href="../MntAlcalde" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-wrench tx-20"></i>
                    <span class="menu-item-label">Mantenimiento Alcalde</span>
                </div>
            </a>
            <a href="../UsuCertificado" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-document-text tx-20"></i>
                    <span class="menu-item-label">Certificados de posesión</span>
                </div>
            </a>
            <a href="../UsuTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-clipboard tx-20"></i>
                    <span class="menu-item-label">Títulos de propiedad</span>
                </div>
            </a>
            <a href="../SubGerenteCertificado" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-folder tx-20"></i>
                    <span class="menu-item-label">Certificados Subgerente</span>
                </div>
            </a>
            <a href="../SubGerenteTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-briefcase tx-20"></i>
                    <span class="menu-item-label">Títulos Subgerente</span>
                </div>
            </a>
            <a href="../GerenteCertificado" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-folder tx-20"></i>
                    <span class="menu-item-label">Certificados Gerente</span>
                </div>
            </a>
            <a href="../GerenteTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-briefcase tx-20"></i>
                    <span class="menu-item-label">Títulos Gerente</span>
                </div>
            </a>
            <a href="../AlcaldeTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-ribbon-a tx-20"></i>
                    <span class="menu-item-label">Títulos Alcalde</span>
                </div>
            </a>
            <?php
        } else if($_SESSION["usua_rol"]==2){
            ?>

            <a href="../UsuCertificado" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-document-text tx-20"></i>
                    <span class="menu-item-label">Certificados de posesión</span>
                </div>
            </a>
            <a href="../UsuTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-clipboard tx-20"></i>
                    <span class="menu-item-label">Títulos de propiedad</span>
                </div>
            </a>
            <?php
        } else if($_SESSION["usua_rol"]==3){
            ?>
            <a href="../SubGerenteCertificado" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-folder tx-20"></i>
                    <span class="menu-item-label">Certificados Subgerente</span>
                </div>
            </a>
            <a href="../SubGerenteTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-briefcase tx-20"></i>
                    <span class="menu-item-label">Títulos Subgerente</span>
                </div>
            <?php
        } else if($_SESSION["usua_rol"]==4){
            ?>
            <a href="../GerenteCertificado" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-folder tx-20"></i>
                    <span class="menu-item-label">Certificados Gerente</span>
                </div>
            </a>
            <a href="../GerenteTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-briefcase tx-20"></i>
                    <span class="menu-item-label">Títulos Gerente</span>
                </div>
            <?php
        } else if($_SESSION["usua_rol"]==5){
            ?>
            <a href="../AlcaldeTitulo" class="br-menu-link">
                <div class="br-menu-item">
                    <i class="menu-item-icon icon ion-ribbon-a tx-20"></i>
                    <span class="menu-item-label">Títulos Alcalde</span>
                </div>
            <?php
        }
        ?>
      
        </a>
        <a href="../html/Logout.php" class="br-menu-link">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-power tx-20"></i>
                <span class="menu-item-label">Cerrar Sesión</span>
            </div>
        </a>
    </div>
</div>
