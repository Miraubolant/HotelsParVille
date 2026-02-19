<?php
/**
 * Composant Sidebar CTA (Expedia affiliate)
 * Usage: include avec optionnel $ville (string ou array), $region
 */

// Gestion de $ville qui peut être un string ou un array
$sidebarVille = null;
if (isset($ville)) {
    $sidebarVille = is_array($ville) ? ($ville['nom_standard'] ?? null) : $ville;
}
$sidebarRegion = $region['nom'] ?? 'votre région';
?>

<div class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-6 shadow-xl text-white">
    <h3 class="text-lg font-bold mb-2">
        <?php if ($sidebarVille): ?>
            Planifiez votre séjour à <?= e($sidebarVille) ?>
        <?php else: ?>
            Envie d'évasion ?
        <?php endif; ?>
    </h3>
    <p class="text-primary-100 text-sm mb-4">
        Découvrez les plus beaux hébergements de charme en <strong class="text-white"><?= e($sidebarRegion) ?></strong> et réservez votre séjour idéal.
    </p>

    <ul class="space-y-2 mb-6">
        <li class="flex items-center text-sm">
            <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Réservation facile
        </li>
        <li class="flex items-center text-sm">
            <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Meilleurs prix garantis
        </li>
        <li class="flex items-center text-sm">
            <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Hébergements vérifiés
        </li>
    </ul>

    <a href="https://expedia.com/affiliate/Ct26O9m" target="_blank" rel="noopener nofollow sponsored"
       class="block w-full text-center bg-white text-primary-600 font-bold py-3 px-4 rounded-xl hover:bg-gray-50 transition-colors shadow-lg">
        Rechercher sur Expedia
    </a>
    <p class="text-center text-xs text-primary-200 mt-3">Comparez et réservez en toute simplicité</p>
</div>
