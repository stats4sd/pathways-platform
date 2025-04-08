<li class="nav-item"><a class="nav-link" href="{{ backpack_url("crop") }}"><i class="las la-leaf nav-icon"></i>Cultures</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("farm") }}"><i class="las la-seedling nav-icon"></i>UPAs</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("farm_detail") }}"><i class="las la-seedling nav-icon"></i>Détails UPA</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("field") }}"><i class="las la-seedling nav-icon"></i>Champs</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("plot") }}"><i class="las la-seedling nav-icon"></i>Parcelles</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("interest_point") }}"><i class="las la-map-marker nav-icon"></i>Points d'intérêt</a></li>

<li class="mt-3 nav-item"><a class="nav-link" href="{{ backpack_url("planting") }}"><i class="las la-poll-h nav-icon"></i>Semis</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("planting_detail") }}"><i class="las la-poll nav-icon"></i>Semis - Culture</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("post_planting") }}"><i class="las la-poll-h nav-icon"></i>Post-Semis</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("post_planting_detail") }}"><i class="las la-poll nav-icon"></i>Post-Semis - Culture</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("harvest") }}"><i class="las la-poll-h nav-icon"></i>Récolte</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("harvest_detail") }}"><i class="las la-poll nav-icon"></i>Récolte - Culture</a></li>

<li class="mt-3 nav-item"><a class="nav-link" href="{{ backpack_url("farm_expense") }}"><i class="las la-poll-h nav-icon"></i>Depenses UPA</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("organic_fertiliser") }}"><i class="las la-poll-h nav-icon"></i>Fumure Organique</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("human_cereal_need") }}"><i class="las la-poll nav-icon"></i>Besoins Cereales Humain</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("animal_feed") }}"><i class="las la-poll-h nav-icon"></i>Alimentation Animaux</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url("animal_feed_category") }}"><i class="las la-poll nav-icon"></i>Alimentation Animaux - Categorie</a></li>

<li class="mt-3 mb-1 nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-map"></i>Lieux</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url('region') }}"><i class="las la-map-marker nav-icon"></i>Regions</a></li>
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url('cercle') }}"><i class="las la-map-marker nav-icon"></i>Cercles</a></li>
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url('commune') }}"><i class="las la-map-marker nav-icon"></i>Communes</a></li>
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url('village') }}"><i class="las la-map-marker nav-icon"></i>Villages</a></li>
    </ul>
</li>

<li class="mt-3 mb-1 nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-wpforms"></i>Collecte de<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Données</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url("xlsform-subject") }}"><i class="la la-tags nav-icon"></i> Form Subjects</a></li>
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url("xlsform-template") }}"><i class="la la-wpforms nav-icon"></i> Form Templates</a></li>
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url('team') }}"><i class="nav-icon las la-users"></i> Teams</a></li>
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url("xlsform") }}"><i class="la la-wpforms nav-icon"></i> Team Forms</a></li>
        <li class='nav-item ml-2'><a class="nav-link" href='{{ backpack_url('submission') }}'><i class='nav-icon la la-clipboard-check'></i> Submissions</a></li>
    </ul>
</li>


<li class="mt-3 mb-1 nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user-cog"></i>Gestion des<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Utilisateurs</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item ml-2"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Utilisateurs</span></a></li>
        <li class='nav-item ml-2'><a class='nav-link' href='{{ backpack_url('invite') }}'><i class='nav-icon las la-user-plus'></i> Invitations</a></li>
    </ul>
</li>