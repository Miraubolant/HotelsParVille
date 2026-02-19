<?php
/**
 * Composant CTA Recherche Hébergement (Widget Expedia)
 * Usage: include avec optionnel $ville (string ou array), $codePostal
 */

// Gestion de $ville qui peut être un string ou un array
$ctaVille = null;
if (isset($ville)) {
    $ctaVille = is_array($ville) ? ($ville['nom_standard'] ?? null) : $ville;
}
$ctaTitle = $ctaVille
    ? "Trouvez votre hébergement idéal à " . e($ctaVille)
    : "Trouvez votre hébergement idéal";
?>

<section id="devis" class="bg-gradient-to-br from-primary-600 to-primary-800 rounded-2xl p-6 shadow-xl">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">
            <?= $ctaTitle ?>
        </h2>
        <p class="text-primary-100">
            Trouvez les meilleurs hébergements de charme près de chez vous
        </p>
    </div>

    <div class="bg-white text-gray-900 rounded-xl p-6 shadow-inner">
        <!-- Expedia Search Widget -->
        <div class="eg-widget" data-widget="search" data-program="fr-expedia" data-lobs="stays" data-network="pz" data-camref="1110lzZyN" data-pubref=""></div>
    </div>

    <div class="mt-4 flex flex-wrap justify-center gap-4 text-sm text-primary-100">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Réservation facile</span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Meilleurs prix</span>
        </div>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>Hébergements vérifiés</span>
        </div>
    </div>
</section>
