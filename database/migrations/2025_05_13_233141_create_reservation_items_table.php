    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {

        public function up(): void
        {
            Schema::create('reservation_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
                $table->foreignId('menu_item_id')->constrained();
                $table->integer('quantity')->unsigned()->default(1);
                $table->decimal('price_at_reservation', 10, 2);
                $table->decimal('discount_amount', 10, 2)->default(0);
                $table->string('discount_type')->nullable(); 
                $table->timestamps();
                $table->index(['reservation_id', 'menu_item_id']);
            });
        }
        public function down(): void
        {
            Schema::dropIfExists('reservation_items');
        }
    };
