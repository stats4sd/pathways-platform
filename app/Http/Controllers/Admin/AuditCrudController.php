<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AuditCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AuditCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Audit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/audit');
        CRUD::setEntityNameStrings('audit', 'audits');
    }

    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');

        CRUD::column('created_at')
            ->label('Date / Heure');

        CRUD::column('user_id')
            ->label('Utilisateur')
            ->entity('user')
            ->attribute('name')
            ->model(User::class);

        CRUD::column('event')
            ->label('Événement')
            ->wrapper([
                'class' => function ($crud, $column, $entry) {
                    return match ($entry->event) {
                        'created' => 'badge bg-success',
                        'updated' => 'badge bg-warning',
                        'deleted' => 'badge bg-danger',
                        default => 'badge bg-secondary',
                    };
                }
            ])
            ->value(function ($entry) {
                return match ($entry->event) {
                    'created' => 'Créé',
                    'updated' => 'Mis à jour',
                    'deleted' => 'Supprimé',
                    default => $entry->event,
                };
            });

            CRUD::column('auditable')
                ->label('Objet')
                ->type('closure')
                ->function(function ($entry) {

                    $model = class_basename($entry->auditable_type);

                    $modelLabels = [
                        'Farm' => 'UPA',
                        'FarmDetail' => 'Détails UPA',
                        'Field' => 'Champ',
                        'Plot' => 'Parcelle',
                        'InterestPoint' => 'Point d\'intérêt',

                        'Planting' => 'Semis',
                        'PlantingDetail' => 'Semis - Culture',
                        'PostPlanting' => 'Post-Semis',
                        'PostPlantingDetail' =>'Post-Semis - Culture',
                        'Harvest' => 'Récolte',
                        'HarvestDetail' => 'Récolte - Culture',

                        'FarmExpense' => 'Dépenses UPA',
                        'OrganicFertiliser' => 'Fumure Organique',
                        'HumanCerealNeed' => 'Besoins Cereales Humain',
                        'AnimalFeed' => 'Alimentation Animal',
                        'AnimalFeedCategory' => 'Alimentation Animaux - Categorie',

                    ];

                    return ($modelLabels[$model] ?? $model) . ' ' . $entry->auditable_id;
                });

            CRUD::column('old_values')
                ->label('Anciennes valeurs')
                ->type('closure')
                ->function(function ($entry) {
                    return collect($entry->old_values)
                        ->map(fn($value, $key) => "<strong>$key:</strong> $value")
                        ->implode('<br>');
                })
                ->escaped(false);

            CRUD::column('new_values')
                ->label('Nouvelles valeurs')
                ->type('closure')
                ->function(function ($entry) {
                    return collect($entry->new_values)
                        ->map(fn($value, $key) => "<strong>$key:</strong> $value")
                        ->implode('<br>');
                })
                ->escaped(false);

    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

}
