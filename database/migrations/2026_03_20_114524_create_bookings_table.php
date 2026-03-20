<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // ── Reference ─────────────────────────────────────────────────
            $table->string('reference')->unique()
                  ->comment('Human-readable booking ref e.g. PX-20240115-0042');

            // ── Service ───────────────────────────────────────────────────
            $table->foreignId('service_id')
                  ->nullable()
                  ->constrained('services')->nullOnDelete();
            $table->string('service_name')
                  ->comment('Snapshot of service name at time of booking');

            // ── Vehicle ───────────────────────────────────────────────────
            $table->string('vehicle_reg')
                  ->comment('Registration number e.g. KCA 123A');
            $table->string('vehicle_make_model')->nullable()
                  ->comment('e.g. Toyota Corolla');

            // ── Schedule ──────────────────────────────────────────────────
            $table->date('booking_date');
            $table->string('booking_time')
                  ->comment('e.g. 09:00 AM');
            $table->dateTime('scheduled_at')
                  ->comment('Combined booking_date + booking_time as a single datetime');

            // ── Customer ──────────────────────────────────────────────────
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            // ── Booking Source ────────────────────────────────────────────
            $table->enum('source', ['website', 'walk_in', 'phone', 'whatsapp', 'referral', 'other'])
                  ->default('website');

            // ── Status ────────────────────────────────────────────────────
            $table->enum('status', [
                'pending',      // just submitted, awaiting confirmation
                'confirmed',    // garage confirmed the slot
                'in_progress',  // vehicle is being serviced
                'completed',    // service done
                'cancelled',    // cancelled by customer or garage
                'no_show',      // customer did not arrive
            ])->default('pending');

            $table->text('cancellation_reason')->nullable();

            // ── Notes ─────────────────────────────────────────────────────
            $table->text('customer_notes')->nullable()
                  ->comment('Any notes the customer added');
            $table->text('staff_notes')->nullable()
                  ->comment('Internal notes added by staff');

            // ── Estimated Duration ────────────────────────────────────────
            $table->unsignedSmallInteger('estimated_duration_minutes')->nullable()
                  ->comment('Snapshot of service duration at time of booking');

            // ── Pricing snapshot ──────────────────────────────────────────
            $table->unsignedInteger('price_quoted')->nullable()
                  ->comment('Price quoted to customer at booking (KES)');
            $table->unsignedInteger('price_charged')->nullable()
                  ->comment('Actual amount charged after service (KES)');

            // ── Timestamps ────────────────────────────────────────────────
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};