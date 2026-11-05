<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class HmsDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Nigerian names and places suit the target market.
        $faker = Faker::create('en_NG');
        $now = Carbon::now();

        $patients = [];
        for ($i = 1; $i <= 12; $i++) {
            $firstName = $faker->firstName();
            $lastName = $faker->lastName();
            $fullName = $firstName.' '.$lastName;
            $patientId = sprintf('PT-%s-%04d', $now->format('y'), $i);
            $visitDate = $faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d');
            // 'date' is the date of birth, so age and DOB agree on cards and printouts.
            $age = $faker->numberBetween(8, 78);
            $place = $faker->randomElement([['Lagos', 'Lagos'], ['Ibadan', 'Oyo'], ['Abuja', 'FCT'], ['Port Harcourt', 'Rivers'], ['Enugu', 'Enugu'], ['Abeokuta', 'Ogun'], ['Benin City', 'Edo'], ['Kano', 'Kano']]);
            $dateOfBirth = $now->copy()->subYears($age)->subDays($faker->numberBetween(0, 364))->format('Y-m-d');

            $patients[] = [
                'patient_id' => $patientId,
                'fullname' => $fullName,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'date' => $dateOfBirth,
                'datee' => $visitDate,
                'age' => (string) $age,
                'gender' => $faker->randomElement(['male', 'female']),
                'phone' => '080'.(string) $faker->numberBetween(10000000, 99999999),
                'email' => Str::lower($firstName.'.'.$lastName.$i.'@example.com'),
                'city' => $place[0],
                'state' => $place[1],
                'street' => $faker->streetAddress(),
                'occupation' => $faker->jobTitle(),
                'emergency_fullname' => $faker->name(),
                'emergency_relationship' => $faker->randomElement(['Parent', 'Sibling', 'Spouse', 'Guardian']),
                'emergency_phone' => '081'.(string) $faker->numberBetween(10000000, 99999999),
                'emergency_email' => $faker->safeEmail(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $this->seedIfEmpty('users', $this->makeUsers($now));
        $this->seedIfEmpty('doctors', [
            ['name' => 'Dr. Amina Okafor', 'password' => Hash::make('doctor123'), 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dr. Tunde Afolabi', 'password' => Hash::make('doctor123'), 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dr. Mariam Bello', 'password' => Hash::make('doctor123'), 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('registers', [
            ['name' => 'frontdesk1', 'password' => Hash::make('welcome123'), 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'frontdesk2', 'password' => Hash::make('welcome123'), 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('adminpasswords', [
            ['name' => 'superadmin', 'password' => Hash::make('admin123'), 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('adpasswords', [
            ['name' => 'legacy_admin', 'password' => Hash::make('admin123'), 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('patient_infos', $patients);

        $this->seedIfEmpty('appointments', $this->makeAppointments($patients, $faker, $now));
        $this->seedIfEmpty('vitals', $this->makeVitals($patients, $faker, $now));
        $this->seedIfEmpty('vital2s', $this->makeVital2($patients, $faker, $now));
        $this->seedIfEmpty('treats', $this->makeTreats($patients, $faker, $now));

        $this->seedIfEmpty('drugs', [
            ['sn' => 'DR-001', 'name' => 'Timolol Eye Drop', 'price' => '4500', 'special_code' => 'GLA', 'drug_type' => 'Drops', 'quantity' => 120, 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'DR-002', 'name' => 'Artificial Tears', 'price' => '3000', 'special_code' => 'DRY', 'drug_type' => 'Drops', 'quantity' => 200, 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'DR-003', 'name' => 'Acetazolamide 250mg', 'price' => '2500', 'special_code' => 'IOP', 'drug_type' => 'Tablet', 'quantity' => 90, 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'DR-004', 'name' => 'Ciprofloxacin Eye Ointment', 'price' => '3800', 'special_code' => 'INF', 'drug_type' => 'Ointment', 'quantity' => 65, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('frames', [
            ['sn' => 'FR-001', 'name' => 'Aviator Silver', 'price' => '18000', 'special_code' => 'METAL', 'quantity' => 24, 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'FR-002', 'name' => 'Classic Black Acetate', 'price' => '14500', 'special_code' => 'ACET', 'quantity' => 36, 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'FR-003', 'name' => 'Kids Flexi Blue', 'price' => '12000', 'special_code' => 'KIDS', 'quantity' => 18, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('lenses', [
            ['sn' => 'LN-001', 'name' => 'Single Vision CR-39', 'price' => '9500', 'special_code' => 'SV', 'quantity' => 40, 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'LN-002', 'name' => 'Photochromic Blue Cut', 'price' => '22000', 'special_code' => 'PHO', 'quantity' => 28, 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'LN-003', 'name' => 'Progressive Premium', 'price' => '38000', 'special_code' => 'PROG', 'quantity' => 16, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('services', [
            ['sn' => 'SV-001', 'name' => 'Comprehensive Eye Exam', 'price' => '7000', 'special_code' => 'CONS', 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'SV-002', 'name' => 'Intraocular Pressure Check', 'price' => '2500', 'special_code' => 'IOP', 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'SV-003', 'name' => 'Refraction Assessment', 'price' => '5000', 'special_code' => 'REF', 'created_at' => $now, 'updated_at' => $now],
            ['sn' => 'SV-004', 'name' => 'Fundoscopy', 'price' => '4500', 'special_code' => 'FND', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->seedIfEmpty('inventories', $this->makeInventories($faker, $now));
        $this->seedIfEmpty('tests', $this->makeTestStockRows($faker, $now));

        [$invoices, $invos] = $this->makeInvoices($patients, $faker, $now);
        $this->seedIfEmpty('invoices', $invoices);
        $this->seedIfEmpty('invos', $invos);

        $this->seedIfEmpty('notifications', $this->makeNotifications($patients, $now));
        $this->seedIfEmpty('opticians', $this->makeOpticians($patients, $faker, $now));
        $this->seedIfEmpty('events', $this->makeEvents($faker, $now));
        $this->seedIfEmpty('images', $this->makeImages($patients, $now));

        $this->seedIfEmpty('sender_models', [
            ['created_at' => $now, 'updated_at' => $now],
        ]);
    }

    private function seedIfEmpty(string $table, array $rows): void
    {
        if (!Schema::hasTable($table) || empty($rows)) {
            return;
        }

        if (DB::table($table)->count() > 0) {
            return;
        }

        $availableColumns = array_flip(Schema::getColumnListing($table));
        $normalizedRows = [];

        foreach ($rows as $row) {
            $normalizedRows[] = array_intersect_key($row, $availableColumns);
        }

        DB::table($table)->insert($normalizedRows);
    }

    // One demo login per role. All share the password in DEMO_PASSWORD (see docs/DEMO_GUIDE.md).
    public const DEMO_PASSWORD = 'Demo-2026!';

    private function makeUsers(Carbon $now): array
    {
        $accounts = [
            ['System Admin', 'admin@clearsight.demo', 'admin'],
            ['Dr. Amina Okafor', 'doctor@clearsight.demo', 'user'],
            ['Bisi Adeyemi', 'frontdesk@clearsight.demo', 'reception'],
            ['Femi Johnson', 'optician@clearsight.demo', 'optician'],
        ];
        $hasRole = Schema::hasTable('users') && Schema::hasColumn('users', 'role');

        return array_map(function ($account) use ($now, $hasRole) {
            [$name, $email, $role] = $account;
            $row = ['name' => $name, 'email' => $email, 'password' => Hash::make(self::DEMO_PASSWORD), 'email_verified_at' => $now, 'remember_token' => Str::random(10), 'created_at' => $now, 'updated_at' => $now];
            if ($hasRole) {
                $row['role'] = $role;
            }

            return $row;
        }, $accounts);
    }

    private function makeAppointments(array $patients, $faker, Carbon $now): array
    {
        $rows = [];
        foreach (array_slice($patients, 0, 8) as $patient) {
            $rows[] = [
                'name' => $patient['fullname'],
                'date' => $faker->dateTimeBetween('-20 days', '+20 days')->format('Y-m-d'),
                'time' => $faker->time('H:i:s'),
                'complaints' => $faker->randomElement(['Blurred vision', 'Headache while reading', 'Eye redness', 'Night glare', 'Routine checkup']),
                'phone_number' => $patient['phone'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeVitals(array $patients, $faker, Carbon $now): array
    {
        $rows = [];
        foreach (array_slice($patients, 0, 8) as $patient) {
            $rows[] = [
                'patient_code' => $patient['patient_id'],
                'cc' => $faker->randomElement(['Distance blur', 'Near blur', 'Itchy eyes']),
                'pohx' => 'No previous ocular surgery',
                'pmhx' => $faker->randomElement(['Nil', 'Hypertension', 'Diabetes']),
                'odunaided' => '6/18',
                'osunaided' => '6/24',
                'lodsph' => '-1.00',
                'lodcyl' => '-0.50',
                'lodaxis' => '180',
                'lossph' => '-0.75',
                'loscyl' => '-0.50',
                'losaxis' => '170',
                'addsph' => '+1.50',
                'srodsphere' => '-1.00',
                'srodcyl' => '-0.50',
                'srodaxis' => '180',
                'srodva' => '6/6',
                'fodsph' => '-1.00',
                'fodcyl' => '-0.25',
                'fodaxis' => '175',
                'fodva' => '6/6',
                'eyelidod' => 'Normal',
                'eyelidos' => 'Normal',
                'corneaod' => 'Clear',
                'corneaos' => 'Clear',
                'lensod' => $faker->randomElement(['Clear', 'Early NS']),
                'lensos' => $faker->randomElement(['Clear', 'Early NS']),
                'odnct' => (string) $faker->numberBetween(12, 20),
                'osnct' => (string) $faker->numberBetween(12, 20),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeVital2(array $patients, $faker, Carbon $now): array
    {
        $rows = [];
        foreach (array_slice($patients, 0, 8) as $patient) {
            $rows[] = [
                'patient_code' => $patient['patient_id'],
                'srosphere' => '-0.75',
                'sroscyl' => '-0.25',
                'srosaxis' => '5',
                'srosva' => '6/6',
                'srosadd' => '+1.25',
                'srosnva' => 'N6',
                'fossph' => '-0.75',
                'foscyl' => '-0.25',
                'fosaxis' => '10',
                'fosva' => '6/6',
                'fosadd' => '+1.25',
                'fosnva' => 'N6',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeTreats(array $patients, $faker, Carbon $now): array
    {
        $rows = [];
        foreach (array_slice($patients, 0, 8) as $patient) {
            $rows[] = [
                'patient_id' => $patient['patient_id'],
                'dosage' => '1 drop b.i.d x 14 days',
                'duration' => $faker->randomElement(['1 week', '2 weeks', '1 month']),
                'tab' => 'Vitamin A',
                'gutt' => 'Artificial tears',
                'oc' => 'Warm compress',
                'sur' => 'Nil',
                'rtc' => 'Review in 2 weeks',
                'remark' => 'Advise reduced screen time',
                'prescription' => 'OD -1.00/-0.50 x 180, OS -0.75/-0.50 x 170, Add +1.50',
                'single_vision' => json_encode(['lens' => 'SV CR-39', 'coat' => 'Blue cut']),
                'bifocal' => json_encode(['type' => 'Flat-top', 'segment' => '28']),
                'special_order' => json_encode(['photochromic' => true, 'delivery_days' => 5]),
                'invisible' => json_encode(['index' => '1.67', 'aspheric' => true]),
                'progressive' => json_encode(['design' => 'Soft design', 'corridor' => '14mm']),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeInventories($faker, Carbon $now): array
    {
        $rows = [];
        for ($i = 1; $i <= 6; $i++) {
            $qtyIn = $faker->numberBetween(10, 40);
            $qtyOut = $faker->numberBetween(0, 8);
            $rows[] = [
                'date' => $faker->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
                'new_stock' => (string) $qtyIn,
                'name' => $faker->randomElement(['Timolol Eye Drop', 'Single Vision CR-39', 'Classic Black Acetate']),
                'patient_code' => sprintf('PT-%s-%04d', $now->format('y'), $faker->numberBetween(1, 12)),
                'booklet_no' => 'BK-'.(string) $faker->numberBetween(1000, 9999),
                'qty_in' => (string) $qtyIn,
                'qty_out' => (string) $qtyOut,
                'balance' => (string) ($qtyIn - $qtyOut),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeTestStockRows($faker, Carbon $now): array
    {
        $rows = [];
        for ($i = 1; $i <= 5; $i++) {
            $qtyIn = $faker->numberBetween(5, 25);
            $qtyOut = $faker->numberBetween(0, 5);
            $rows[] = [
                'sn' => 'TS-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT),
                'date' => $faker->dateTimeBetween('-45 days', 'now')->format('Y-m-d'),
                'new_stock' => (string) $qtyIn,
                'name' => $faker->randomElement(['Lens Cleaning Kit', 'Eye Shield', 'Trial Frame']),
                'patient_code' => sprintf('PT-%s-%04d', $now->format('y'), $faker->numberBetween(1, 12)),
                'booklet_no' => 'TB-'.(string) $faker->numberBetween(1000, 9999),
                'qty_in' => (string) $qtyIn,
                'qty_out' => (string) $qtyOut,
                'balance' => (string) ($qtyIn - $qtyOut),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeInvoices(array $patients, $faker, Carbon $now): array
    {
        $invoiceRows = [];
        $invoRows = [];

        foreach (array_slice($patients, 0, 8) as $patient) {
            $items = [
                ['name' => 'Consultation', 'price' => 7000, 'qty' => 1],
                ['name' => $faker->randomElement(['Single Vision Lens', 'Photochromic Lens', 'Frame']), 'price' => $faker->randomElement([9500, 14500, 22000]), 'qty' => $faker->numberBetween(1, 2)],
            ];

            $names = array_column($items, 'name');
            $prices = array_column($items, 'price');
            $qty = array_column($items, 'qty');
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['qty'];
            }
            // Discount is a percentage of the subtotal, matching InvoiceController::save.
            $discount = $faker->randomElement([0, 0, 5, 10]);
            $amount = $subtotal - round($subtotal * $discount / 100, 2);

            $invoiceRows[] = [
                'pid' => $patient['patient_id'],
                'name' => json_encode($names),
                'price' => json_encode($prices),
                'qty' => json_encode($qty),
                'discount' => $discount,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $invoRows[] = [
                'pid' => $patient['patient_id'],
                'name' => json_encode($names),
                'price' => json_encode($prices),
                'qty' => json_encode($qty),
                'discount' => $discount,
                'amount' => $amount,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return [$invoiceRows, $invoRows];
    }

    private function makeNotifications(array $patients, Carbon $now): array
    {
        $rows = [];
        foreach (array_slice($patients, 0, 6) as $patient) {
            $rows[] = [
                'message' => 'Prescription ready for pickup',
                'patient_name' => $patient['fullname'],
                'added_by' => 'System Admin',
                'pid' => $patient['patient_id'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeOpticians(array $patients, $faker, Carbon $now): array
    {
        $rows = [];
        foreach (array_slice($patients, 0, 6) as $patient) {
            $rows[] = [
                'date' => $faker->dateTimeBetween('-20 days', 'now')->format('Y-m-d'),
                'patient_name' => $patient['fullname'],
                'power' => 'OD -1.00/-0.50 x 180, OS -0.75/-0.50 x 170',
                'posted_from' => $faker->randomElement(['Main Branch', 'Satellite Clinic']),
                'card_number' => 'CARD-'.(string) $faker->numberBetween(10000, 99999),
                'frame_type' => $faker->randomElement(['Metal', 'Acetate', 'Rimless']),
                'qty' => (string) $faker->numberBetween(1, 2),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeEvents($faker, Carbon $now): array
    {
        $rows = [];
        for ($i = 1; $i <= 6; $i++) {
            $start = $faker->dateTimeBetween('-10 days', '+10 days');
            $end = (clone $start)->modify('+2 hours');
            $rows[] = [
                'title' => $faker->randomElement(['Surgery Follow-up Clinic', 'Staff Meeting', 'Outreach Screening', 'Inventory Reconciliation']),
                'start' => Carbon::parse($start)->format('Y-m-d H:i:s'),
                'end' => Carbon::parse($end)->format('Y-m-d H:i:s'),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    private function makeImages(array $patients, Carbon $now): array
    {
        $rows = [];
        foreach (array_slice($patients, 0, 4) as $index => $patient) {
            $rows[] = [
                'name' => $patient['patient_id'],
                'title' => 'Fundus image '.($index + 1),
                'file_path' => 'images/'.$patient['patient_id'].'-fundus.jpg',
                'path' => 'images/'.$patient['patient_id'].'-fundus.jpg',
                'mime_type' => 'image/jpeg',
                'size' => 240000,
                'image_data' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }
}
