<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

/**
 * Populates long_description, features, process, image, price_from, price_to,
 * and duration_minutes on existing services for visualisation purposes.
 *
 * Run with: php artisan db:seed --class=ServiceDetailSeeder
 */
class ServiceDetailSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'assets/images/carwash.avif',
            'assets/images/car.avif',
        ];

        $data = [

            // ── TYRE SERVICES ─────────────────────────────────────────────────────

            'tyre-fitting' => [
                'long_description' => 'Professional tyre fitting using state-of-the-art Hunter mounting and balancing equipment. We handle everything from compact runabouts to wide-profile performance tyres on luxury SUVs, ensuring every wheel leaves the bay perfectly balanced and torqued to manufacturer specification.',
                'price_from'       => 800,
                'price_to'         => 2500,
                'duration_minutes' => 45,
                'features'         => [
                    'Hunter DSP9700 road-force balancing on every fitment',
                    'Tyre pressure set to manufacturer specification',
                    'TPMS sensor re-calibration where applicable',
                    'Visual inspection of bead seat, rim flange and valve stem',
                    'Torque wrench tightening to OEM spec',
                ],
                'process' => [
                    ['title' => 'Wheel Removal',        'detail' => 'Vehicle safely raised on four-post lift; wheels removed with calibrated impact wrench and torque sticks.'],
                    ['title' => 'Tyre Demounting',      'detail' => 'Old tyre removed on Hunter wheel-safe changer; rim inspected for corrosion or kerb damage.'],
                    ['title' => 'New Tyre Mounting',    'detail' => 'Fresh tyre mounted using plastic-tipped head; bead lubricated and seated at correct pressure.'],
                    ['title' => 'Road-Force Balancing', 'detail' => 'Each assembly spun on Hunter DSP9700 — weight placements eliminate vibration at motorway speeds.'],
                    ['title' => 'Refit & Torque',       'detail' => 'Wheels refitted and torqued in a star pattern to OEM specification; TPMS reset if equipped.'],
                ],
            ],

            'tyre-rotation' => [
                'long_description' => 'Regular tyre rotation extends the life of your tyres by up to 30% and ensures even wear across all four corners. Our technicians follow the rotation pattern specified by your vehicle manufacturer — cross, straight or rearward — and reset the TPMS afterwards.',
                'price_from'       => 500,
                'price_to'         => 800,
                'duration_minutes' => 30,
                'features'         => [
                    'Manufacturer-specified rotation pattern (cross / straight / rearward)',
                    'Visual wear inspection on all four tyres',
                    'Tyre pressure check and adjustment on every corner',
                    'TPMS reset and validation',
                    'Wheel torque check after rotation',
                ],
                'process' => [
                    ['title' => 'Pre-Rotation Inspection', 'detail' => 'Tread depth measured on all four tyres; wear patterns noted for any alignment concerns.'],
                    ['title' => 'Rotation',                'detail' => 'Wheels moved per manufacturer pattern on four-post lift.'],
                    ['title' => 'Inflation & Torque',      'detail' => 'Every tyre inflated to spec; lug nuts torqued to OEM value.'],
                    ['title' => 'TPMS Reset',              'detail' => 'Sensor positions updated in the vehicle ECU if applicable.'],
                ],
            ],

            'puncture-repair' => [
                'long_description' => 'We use only plug-and-patch repair — the only method approved by tyre manufacturers. Sidewall punctures and run-flat damage are assessed honestly; if a repair would compromise safety, we will tell you clearly rather than risk your life on the road.',
                'price_from'       => 300,
                'price_to'         => 500,
                'duration_minutes' => 30,
                'features'         => [
                    'TPAC-compliant plug-and-patch repair only (no rope plug)',
                    'Internal tyre inspection for secondary damage',
                    'Rim seal inspection and bead clean',
                    'Honest assessment — sidewall and run-flat damage called correctly',
                    'Final pressure check and TPMS validation',
                ],
                'process' => [
                    ['title' => 'Locate & Assess',   'detail' => 'Puncture located; position and angle assessed to determine repairability.'],
                    ['title' => 'Demount & Inspect',  'detail' => 'Tyre removed from rim; full internal inspection for liner damage.'],
                    ['title' => 'Plug-and-Patch',     'detail' => 'Injury buffed, filled with vulcanising compound and sealed with a patch from inside.'],
                    ['title' => 'Cure & Refit',       'detail' => 'Patch cured under pressure; tyre remounted, balanced and refitted.'],
                ],
            ],

            'tyre-pressure-check-inflation' => [
                'long_description' => 'A five-minute service with real consequences. Correct tyre pressure reduces fuel consumption by up to 3%, prevents uneven wear and maintains handling stability. We check all four corners plus the spare against the manufacturer placard, not generic figures.',
                'price_from'       => 100,
                'duration_minutes' => 10,
                'features'         => [
                    'All four tyres + spare checked against manufacturer placard',
                    'Nitrogen inflation available on request',
                    'TPMS sensor function verified',
                    'Visual sidewall and tread inspection included',
                ],
                'process' => [
                    ['title' => 'Placard Check',  'detail' => 'Correct pressures sourced from door-jamb placard for the actual load condition.'],
                    ['title' => 'Measure & Adjust', 'detail' => 'Digital gauge used; each tyre inflated or deflated to exact target.'],
                    ['title' => 'TPMS Verify',    'detail' => 'Dashboard warning cleared and sensor function confirmed.'],
                ],
            ],

            // ── WHEEL ALIGNMENT ───────────────────────────────────────────────────

            '3d-wheel-alignment' => [
                'long_description' => 'Our Hunter HawkEye Elite 3D alignment system measures all four wheels simultaneously with sub-millimetre accuracy. We adjust toe, camber and caster to OEM tolerance — not just "within range" — then produce a before-and-after print-out for your records.',
                'price_from'       => 2500,
                'price_to'         => 4500,
                'duration_minutes' => 60,
                'features'         => [
                    'Hunter HawkEye Elite — sub-0.01° measurement accuracy',
                    'All four wheels measured simultaneously',
                    'Toe, camber and caster adjusted to OEM specification',
                    'Steering wheel centring verified',
                    'Printed before-and-after alignment report',
                    'Suspension pre-inspection at no extra charge',
                ],
                'process' => [
                    ['title' => 'Pre-Alignment Inspection', 'detail' => 'Steering and suspension components checked for wear before alignment — pointless to align a worn suspension.'],
                    ['title' => 'Vehicle Setup',            'detail' => 'Vehicle placed on turn-plates; sensors clamped to all four rims and the system calibrated.'],
                    ['title' => 'Live Measurement',         'detail' => 'All angles measured live and compared against the OEM specification database.'],
                    ['title' => 'Adjustment',               'detail' => 'Toe adjusted first (most critical), then camber and caster where adjustment is available.'],
                    ['title' => 'Report & Road Test',       'detail' => 'Before/after print-out presented; brief road test to confirm straight tracking.'],
                ],
            ],

            'wheel-balancing' => [
                'long_description' => 'Vibration through the steering wheel at 80–120 km/h is almost always a balancing issue. We use Hunter road-force balancing which simulates the weight of the vehicle pressing down on the tyre, catching heavy spots that a standard static balancer misses.',
                'price_from'       => 400,
                'price_to'         => 700,
                'duration_minutes' => 30,
                'features'         => [
                    'Hunter DSP9700 road-force balancer (detects match-mounting issues)',
                    'All four wheels balanced individually',
                    'Old weights removed before rebalancing',
                    'Rim runout measured — bent rims identified',
                    'Vibration root-cause diagnosis included',
                ],
                'process' => [
                    ['title' => 'Remove & Clean',   'detail' => 'Wheels removed; old weights stripped from both inner and outer flanges.'],
                    ['title' => 'Road-Force Spin',  'detail' => 'Each tyre spun on Hunter DSP9700 under a simulated load roller.'],
                    ['title' => 'Weight Placement', 'detail' => 'Machine indicates precise weight placement; clip-on or adhesive weights applied.'],
                    ['title' => 'Verify & Refit',   'detail' => 'Second spin confirms result below 5g residual imbalance; wheel refitted and torqued.'],
                ],
            ],

            // ── LUBES & OIL CHANGE ─────────────────────────────────────────────────

            'engine-oil-filter-change' => [
                'long_description' => 'We use only OEM-grade or better lubricants — Mobil 1, Castrol EDGE, Liqui-Moly or the manufacturer\'s own fill as appropriate for your engine. The oil filter is always replaced; we never reuse. Service sticker applied and the next service reminder set in your instrument cluster if supported.',
                'price_from'       => 3500,
                'price_to'         => 9000,
                'duration_minutes' => 45,
                'features'         => [
                    'OEM-specified viscosity grade and API/ACEA rating',
                    'Branded oil filter (Mann, Mahle or OEM)',
                    'Drain plug washer replaced every service',
                    'Oil level set exactly to the dipstick max mark',
                    'Service interval reset in instrument cluster',
                    'Courtesy multi-point visual inspection included',
                ],
                'process' => [
                    ['title' => 'Warm & Drain',       'detail' => 'Engine run to operating temperature for a full drain; cold oil leaves contaminants behind.'],
                    ['title' => 'Filter & Plug',       'detail' => 'Old filter removed; new filter pre-filled with fresh oil. Drain plug torqued with fresh crush washer.'],
                    ['title' => 'Fill to Spec',        'detail' => 'Correct grade and quantity filled per service manual; level verified on dipstick after a short run.'],
                    ['title' => 'Reset & Document',    'detail' => 'Service interval reset in cluster; sticker placed inside door jamb noting date, mileage and next due.'],
                ],
            ],

            'brake-fluid-change' => [
                'long_description' => 'Brake fluid is hygroscopic — it absorbs moisture over time, which lowers its boiling point and creates spongy pedal feel. We test your current fluid with a refractometer and replace it if moisture content exceeds 3%, using only DOT 4 LV or DOT 5.1 as specified.',
                'price_from'       => 2000,
                'price_to'         => 3500,
                'duration_minutes' => 60,
                'features'         => [
                    'Moisture content tested before work begins',
                    'Full system flush — not a top-up',
                    'DOT 4 LV or DOT 5.1 per manufacturer specification',
                    'All four callipers bled; correct sequence maintained',
                    'Pedal feel and brake warning light verified on completion',
                ],
                'process' => [
                    ['title' => 'Moisture Test',  'detail' => 'Refractometer used to measure water content in the reservoir; result shown to owner.'],
                    ['title' => 'Reservoir Flush', 'detail' => 'Old fluid vacuumed out; reservoir cleaned and filled with fresh fluid.'],
                    ['title' => 'Calliper Bleed',  'detail' => 'Each calliper bled in manufacturer-specified sequence until fresh clear fluid flows at each nipple.'],
                    ['title' => 'Pedal Test',      'detail' => 'Pedal firmness verified; ABS self-test cycle run on vehicles that support it.'],
                ],
            ],

            'gearbox-transmission-oil-change' => [
                'long_description' => 'Automatic and dual-clutch gearboxes run on fluid that degrades with heat cycling. Contaminated ATF causes harsh shifts, slip and ultimately valve body failure. We drain, flush and refill with the exact OEM-specified fluid — not a "universal" substitute.',
                'price_from'       => 5000,
                'price_to'         => 14000,
                'duration_minutes' => 90,
                'features'         => [
                    'OEM-specified ATF or DSG fluid only (e.g. ZF Lifeguard 6/8, Pentosin)',
                    'Drain-and-fill or full flush depending on condition',
                    'Transmission sump filter replacement where applicable',
                    'Fluid level set via overflow plug to factory specification',
                    'Adaptive shift-map reset after service on supported vehicles',
                ],
                'process' => [
                    ['title' => 'Fluid Condition Check', 'detail' => 'Sample of existing fluid drawn; colour and smell assessed; particle test on magnetic drain plug.'],
                    ['title' => 'Drain & Filter',        'detail' => 'Sump dropped where accessible; old filter replaced; magnet cleaned of metallic debris.'],
                    ['title' => 'Fill & Level',          'detail' => 'Correct OEM fluid filled to overflow plug specification at operating temperature.'],
                    ['title' => 'Adaptive Reset',        'detail' => 'Shift adaptation tables cleared via scan tool; test drive to confirm smooth engagement across all ratios.'],
                ],
            ],

            'differential-oil-change' => [
                'long_description' => 'Front, rear and centre differentials require their own dedicated lubricant — particularly limited-slip units which need friction modifier additives. We identify the correct specification from VIN lookup and use only the specified grade.',
                'price_from'       => 2500,
                'price_to'         => 6000,
                'duration_minutes' => 60,
                'features'         => [
                    'VIN-matched fluid specification lookup',
                    'Limited-slip friction modifier included where required',
                    'Fill plug sealing washer always replaced',
                    'Covers front, rear and centre diffs as applicable',
                    'Visual seal inspection and leakdown check',
                ],
                'process' => [
                    ['title' => 'Identify Spec',    'detail' => 'VIN decoded to confirm differential type, ratio and fluid specification.'],
                    ['title' => 'Drain',            'detail' => 'Drain plug removed; old fluid allowed to drain fully; magnetic plug cleaned.'],
                    ['title' => 'Fill to Level',    'detail' => 'New fluid pumped in through fill hole until it reaches the overflow level.'],
                    ['title' => 'Seal Inspection',  'detail' => 'Output shaft seals, pinion seal and housing gasket checked for weeping; flagged if replacement needed.'],
                ],
            ],

            // ── SUSPENSION & STEERING ─────────────────────────────────────────────

            'shock-absorber-replacement' => [
                'long_description' => 'Worn dampers don\'t just make the ride uncomfortable — they increase braking distances and reduce cornering stability. We replace with OEM or brand-matched aftermarket units (Bilstein, KYB, Monroe) and perform a wheel alignment immediately after on the affected axle.',
                'price_from'       => 8000,
                'price_to'         => 35000,
                'duration_minutes' => 180,
                'features'         => [
                    'OEM or Bilstein / KYB / Monroe equivalent fitment',
                    'Shock mounts, bump stops and dust boots replaced as a set',
                    'Spring seats inspected for cracking',
                    'Four-wheel alignment performed after replacement',
                    'Before/after ride-height measurement',
                ],
                'process' => [
                    ['title' => 'Removal',          'detail' => 'Suspension compressed safely; strut assembly or separate damper removed intact.'],
                    ['title' => 'Strip & Rebuild',  'detail' => 'Spring compressed on press; top mount, bump stop and dust boot replaced; new damper fitted.'],
                    ['title' => 'Installation',     'detail' => 'Assembly installed; all fasteners torqued to OEM spec with vehicle at ride height.'],
                    ['title' => 'Alignment',        'detail' => 'Full four-wheel alignment performed; camber and toe confirmed within OEM tolerance.'],
                ],
            ],

            'suspension-bushing-replacement' => [
                'long_description' => 'Rubber bushings degrade silently over time — causing vague steering, uneven tyre wear and chassis noise. We press out worn bushings and fit OEM-grade polyurethane or rubber replacements, restoring the precise geometry the vehicle was designed around.',
                'price_from'       => 3500,
                'price_to'         => 15000,
                'duration_minutes' => 120,
                'features'         => [
                    'OEM rubber or performance polyurethane options available',
                    'Hydraulic press fitment — no drift or hammer damage',
                    'Complete subframe bushing kits available',
                    'Alignment check after replacement',
                    'Before/after road test for noise and feel comparison',
                ],
                'process' => [
                    ['title' => 'Diagnosis',     'detail' => 'Each bushing palpated and levered under load; worn units show crack, tear or excessive deflection.'],
                    ['title' => 'Press Out',     'detail' => 'Component removed from vehicle; old bushing pressed out hydraulically without distorting the housing.'],
                    ['title' => 'New Fitment',   'detail' => 'New bushing pressed in squarely; crush verified; component reinstalled and fasteners torqued at ride height.'],
                    ['title' => 'Alignment',     'detail' => 'Wheel alignment checked after any control arm or subframe bushing work.'],
                ],
            ],

            'ball-joint-replacement' => [
                'long_description' => 'A failed ball joint is a catastrophic failure mode — it can cause the wheel to fold under the car without warning. We test every ball joint for axial and radial play and replace any that show measurable movement, using OEM or equivalent units only.',
                'price_from'       => 4500,
                'price_to'         => 18000,
                'duration_minutes' => 120,
                'features'         => [
                    'Axial and radial play measurement with dial indicator',
                    'OEM or Meyle / Lemförder / Moog equivalent fitment',
                    'Split-pin or self-locking nut replaced as a matter of course',
                    'Grease nipple flushed and lubricated on installation',
                    'Wheel alignment performed after replacement',
                ],
                'process' => [
                    ['title' => 'Play Test',        'detail' => 'Dial indicator measures axial and radial play; manufacturer limits consulted.'],
                    ['title' => 'Removal',          'detail' => 'Taper pressed out of knuckle using separator; control arm removed as necessary.'],
                    ['title' => 'Press-In',         'detail' => 'New ball joint pressed into arm using correct size driver; angle and orientation confirmed.'],
                    ['title' => 'Install & Align',  'detail' => 'Assembly refitted, castellated nut torqued and split-pinned; alignment verified.'],
                ],
            ],

            'tie-rod-end-replacement' => [
                'long_description' => 'Worn tie rod ends create a wandering, vague feel at motorway speeds and are a common cause of rapid inner tyre wear. We replace worn units, set the toe back to the correct measurement and verify the steering wheel is centred.',
                'price_from'       => 3000,
                'price_to'         => 9000,
                'duration_minutes' => 90,
                'features'         => [
                    'Inner and outer tie rod end inspection',
                    'OEM or Meyle / TRW equivalent fitment',
                    'Toe reset to factory specification after replacement',
                    'Steering wheel centring verified',
                    'Gaiter (boot) condition inspection included',
                ],
                'process' => [
                    ['title' => 'Measurement',   'detail' => 'Current toe measured before removal so adjustment span is known.'],
                    ['title' => 'Removal',       'detail' => 'Tie rod end nut removed; taper pressed from steering knuckle with separator.'],
                    ['title' => 'Count Threads', 'detail' => 'Thread count recorded before removal; new unit fitted to same count for approximate toe restoration.'],
                    ['title' => 'Toe & Centre',  'detail' => 'Alignment rack used to dial toe exactly; steering wheel centred and lock-nut torqued.'],
                ],
            ],

            // ── GREASING & RIVETTING ───────────────────────────────────────────────

            'full-chassis-greasing' => [
                'long_description' => 'Most modern vehicles have sealed joints and need no greasing, but older 4x4s, commercials and classic cars have multiple grease nipples that must be serviced regularly. We locate every nipple, clear blocked fittings and pack fresh grease until it purges from the joint.',
                'price_from'       => 1500,
                'price_to'         => 3000,
                'duration_minutes' => 60,
                'features'         => [
                    'All grease nipples located from manufacturer service chart',
                    'Blocked nipples cleared with needle scaler before greasing',
                    'Lithium-complex EP2 grease used throughout',
                    'Propshaft universal joints, slip yoke and centre bearing included',
                    'Brake and clutch pedal pivot points lubricated',
                ],
                'process' => [
                    ['title' => 'Vehicle on Hoist',  'detail' => 'Full underside access on four-post lift; service chart consulted for nipple locations.'],
                    ['title' => 'Clear & Grease',    'detail' => 'Each nipple cleared; grease gun applied until fresh grease purges from the joint seal.'],
                    ['title' => 'Document',          'detail' => 'Any seized or missing nipples noted; replacement fittings installed where accessible.'],
                ],
            ],

            'body-rivetting' => [
                'long_description' => 'Body panels, step bars, skid plates and trim pieces secured with factory rivets often need re-rivetting after panel work, off-road damage or age. We use the correct diameter and material rivet for each application — aluminium or stainless — and dress each head flush.',
                'price_from'       => 500,
                'price_to'         => 3000,
                'duration_minutes' => 60,
                'features'         => [
                    'Correct rivet diameter and material matched to factory spec',
                    'Aluminium, stainless or steel rivets as required',
                    'Backing plates used on thin-gauge panels to prevent pull-through',
                    'Each head dressed flush to panel surface',
                    'Suitable for running boards, skid plates, splash guards and trim',
                ],
                'process' => [
                    ['title' => 'Assess',    'detail' => 'Existing holes measured; correct rivet diameter and grip range selected.'],
                    ['title' => 'Drill Out', 'detail' => 'Old rivets drilled out cleanly; burrs removed from hole edge.'],
                    ['title' => 'Rivet',     'detail' => 'New rivet set with pneumatic rivet gun; mandrel break point confirmed; head dressed flat.'],
                ],
            ],

            // ── SPARE PARTS ───────────────────────────────────────────────────────

            'brake-pads-supply-fitting' => [
                'long_description' => 'We supply and fit only branded pads — Brembo, ATE, Bosch or Textar — that match the friction coefficient specified for your vehicle. Brake dust is cleaned from the calliper, slides lubricated and the pads bedded with a controlled heat cycle before you drive away.',
                'price_from'       => 4500,
                'price_to'         => 18000,
                'duration_minutes' => 90,
                'features'         => [
                    'Brembo, ATE, Bosch or Textar — never white-label pads',
                    'Calliper slide pins cleaned and lubricated',
                    'Rotor thickness measured; minimum spec checked',
                    'Bedding-in procedure performed before handover',
                    'Brake fluid level checked and topped as part of the service',
                ],
                'process' => [
                    ['title' => 'Wheel Removal',   'detail' => 'Wheel removed; calliper unbolted and suspended — never left hanging on the brake hose.'],
                    ['title' => 'Pad Removal',     'detail' => 'Worn pads extracted; calliper carrier cleaned; slide pins removed, cleaned and re-greased.'],
                    ['title' => 'Piston Retract',  'detail' => 'Piston pushed back into calliper using a proper retract tool (not a screwdriver); fluid level monitored.'],
                    ['title' => 'New Pads & Bed',  'detail' => 'New pads fitted; anti-squeal compound applied to backing plate; bedding cycle completed in yard.'],
                ],
            ],

            'brake-disc-supply-fitting' => [
                'long_description' => 'Scored, lipped or below-minimum-thickness discs are a safety risk. We measure your rotors with a micrometer and present the findings before any work begins. Supply and fitment is available for standard, drilled or grooved OEM-replacement discs across all European, Japanese and American marques.',
                'price_from'       => 8000,
                'price_to'         => 40000,
                'duration_minutes' => 120,
                'features'         => [
                    'Disc thickness measured with micrometer; results shown to owner',
                    'EBC, Brembo, ATE or OEM equivalent discs',
                    'Disc runout measured after fitment — must be under 0.05 mm',
                    'New pads always recommended with new discs (matched friction)',
                    'Hub face cleaned to prevent disc thickness variation',
                ],
                'process' => [
                    ['title' => 'Measure',         'detail' => 'Micrometer used at 8 points around the disc; runout checked on the hub with a dial gauge.'],
                    ['title' => 'Remove',          'detail' => 'Calliper and carrier unbolted; disc slid off hub; hub face wire-brushed to bare metal.'],
                    ['title' => 'Fit New Disc',    'detail' => 'New disc fitted to clean hub; locating screw torqued; calliper reassembled with new pads.'],
                    ['title' => 'Runout Check',    'detail' => 'Dial gauge confirms runout below 0.05 mm before wheel is refitted.'],
                    ['title' => 'Bed',             'detail' => 'Bedding cycle performed; at least 10 firm (not panic) stops from 60 km/h to bed new pads and discs together.'],
                ],
            ],

            'spark-plug-replacement' => [
                'long_description' => 'Modern iridium and platinum plugs are specified by heat range and electrode gap — substituting the wrong plug can cause misfires or detonation. We use only OEM or NGK / Denso direct-fit plugs and torque each to specification, never guessing by feel.',
                'price_from'       => 3000,
                'price_to'         => 12000,
                'duration_minutes' => 90,
                'features'         => [
                    'NGK, Denso or OEM manufacturer plugs only',
                    'Correct heat range and electrode gap confirmed from database',
                    'Thread anti-seize applied on aluminium cylinder heads',
                    'Ignition coil boots inspected and replaced if cracked',
                    'Post-fitment idle quality check and misfire scan',
                ],
                'process' => [
                    ['title' => 'Correct Plug Selection', 'detail' => 'VIN used to confirm exact plug part number, heat range and pre-set gap.'],
                    ['title' => 'Access',                  'detail' => 'Engine covers, intake ducts or coil packs removed as needed; work area cleaned to prevent debris ingestion.'],
                    ['title' => 'Remove & Inspect Old',    'detail' => 'Old plugs removed and read — deposits indicate running condition and fuel trim.'],
                    ['title' => 'Fit New',                 'detail' => 'New plugs torqued to spec with a click-type torque wrench; no guesstimating.'],
                    ['title' => 'Verify',                  'detail' => 'Engine started; OBD scanner confirms no misfires on any cylinder.'],
                ],
            ],

            'air-filter-replacement' => [
                'long_description' => 'A blocked air filter robs power and economy. We supply OEM-equivalent panel filters or premium free-flowing alternatives (K&N, BMC) for performance applications, and clean the mass airflow sensor when the filter is replaced.',
                'price_from'       => 1200,
                'price_to'         => 4500,
                'duration_minutes' => 30,
                'features'         => [
                    'OEM-equivalent or K&N / BMC performance option',
                    'MAF sensor cleaned with dedicated sensor-safe spray',
                    'Air box inspected for cracks and loose connections',
                    'Intake hose clamp torques verified',
                    'Post-replacement idle quality check',
                ],
                'process' => [
                    ['title' => 'Access & Remove',  'detail' => 'Air box unclipped or unbolted; old filter removed; housing internal debris cleaned out.'],
                    ['title' => 'MAF Sensor Clean', 'detail' => 'MAF sensor wires sprayed with CRC MAF cleaner; allowed to dry fully before reassembly.'],
                    ['title' => 'New Filter',       'detail' => 'New filter seated and housing secured; all clamps re-torqued.'],
                ],
            ],

            // ── CAR BATTERIES ──────────────────────────────────────────────────────

            'battery-testing' => [
                'long_description' => 'A battery can test fine under no-load but fail under the current demand of cranking. We use a Midtronics conductance tester which applies a controlled AC signal to assess true cold-cranking amps — the only reliable non-destructive test method.',
                'price_from'       => 300,
                'duration_minutes' => 15,
                'features'         => [
                    'Midtronics conductance test — measures actual CCA vs rated CCA',
                    'Alternator output and voltage regulation tested',
                    'Load test at 50% of CCA rating',
                    'Battery health report printed or emailed',
                    'Terminal corrosion cleaned as part of the inspection',
                ],
                'process' => [
                    ['title' => 'Terminal Clean',    'detail' => 'Corrosion removed from both terminals; clean contact essential for accurate reading.'],
                    ['title' => 'Conductance Test',  'detail' => 'Midtronics tester connected; battery rated against CCA, reserve capacity and SOC.'],
                    ['title' => 'Alternator Test',   'detail' => 'Voltage across terminals measured at idle and 2,000 rpm; ripple voltage checked.'],
                    ['title' => 'Report',            'detail' => 'Pass / marginal / replace recommendation with actual measured values provided.'],
                ],
            ],

            'battery-supply-replacement' => [
                'long_description' => 'We stock AGM, EFB and standard lead-acid batteries from Varta, Banner and Bosch — the same brands fitted by manufacturers at the factory. For vehicles with battery management systems, the new battery is registered via OBD-II to prevent charging strategy errors.',
                'price_from'       => 8000,
                'price_to'         => 28000,
                'duration_minutes' => 30,
                'features'         => [
                    'Varta, Banner or Bosch — factory-approved brands',
                    'AGM / EFB for start-stop vehicles (not a standard battery substitute)',
                    'OBD-II battery registration for BMW, Mercedes, VW group and others',
                    'Old battery recycled responsibly',
                    'Terminal protector spray applied after fitment',
                ],
                'process' => [
                    ['title' => 'Test First',       'detail' => 'Existing battery tested to confirm replacement is actually needed.'],
                    ['title' => 'Memory Saver',     'detail' => 'Keep-alive device connected to preserve radio codes, window positions and ECU adaptations during swap.'],
                    ['title' => 'Replace',          'detail' => 'Correct specification battery installed; terminals torqued; hold-down clamp secured.'],
                    ['title' => 'Registration',     'detail' => 'Battery registered via OBD-II on vehicles that require it (BMW, Merc, VW group); charging voltage verified.'],
                ],
            ],

            'battery-jump-start' => [
                'long_description' => 'We use a professional CTEK jump starter — not jump cables that risk spiking sensitive ECUs. If the underlying cause is a failing battery or alternator we will identify it while we are there so you are not back in the same situation the next morning.',
                'price_from'       => 500,
                'duration_minutes' => 20,
                'features'         => [
                    'CTEK professional jump starter — surge-protected, ECU-safe',
                    'Battery test performed after successful start',
                    'Alternator output verified once running',
                    'Cause diagnosis included (failed battery vs. other drain)',
                    'Available on-site during working hours',
                ],
                'process' => [
                    ['title' => 'Safe Connection',   'detail' => 'CTEK jump starter connected with correct polarity; polarity warning light confirmed.'],
                    ['title' => 'Start',             'detail' => 'Vehicle started; jump starter disconnected in the correct order.'],
                    ['title' => 'Root Cause Test',   'detail' => 'Battery CCA tested immediately; alternator output verified — result shared with owner.'],
                ],
            ],

            // ── BUFFING & DETAILING ────────────────────────────────────────────────

            'machine-polishing-buffing' => [
                'long_description' => 'Paint correction using a Rupes BigFoot DA or rotary polisher, compound and finishing polish. A single-stage correction removes light swirl marks; a two-stage process addresses deeper scratches and oxidation. Work is carried out under a colour-matched paint inspection lamp to ensure every defect is addressed.',
                'price_from'       => 15000,
                'price_to'         => 65000,
                'duration_minutes' => 480,
                'features'         => [
                    'Pre-work paint depth gauge reading (baseline recorded)',
                    'Rupes BigFoot DA or rotary polisher',
                    'Menzerna or Koch-Chemie compound and finishing polish',
                    'Single-stage (swirl removal) or two-stage (scratch) packages',
                    'IPA wipe-down to reveal true correction level before sealant',
                    'Paint sealant or carnauba wax finish coat included',
                ],
                'process' => [
                    ['title' => 'Decontamination Wash',  'detail' => 'Snow foam pre-soak, two-bucket wash, clay bar decontamination and iron fallout removal.'],
                    ['title' => 'Tape Off',              'detail' => 'Trim, rubbers and badges masked; paint depth read at 9+ points per panel.'],
                    ['title' => 'Compounding',           'detail' => 'Appropriate cut compound applied with firm pad on rotary or DA; each panel worked in sections.'],
                    ['title' => 'Finishing Polish',      'detail' => 'Finishing polish refines the surface; IPA wipe-down reveals true result.'],
                    ['title' => 'Protection',            'detail' => 'Paint sealant or carnauba wax applied and buffed; trim dressings applied.'],
                ],
            ],

            'full-exterior-detailing' => [
                'long_description' => 'The complete exterior detail: snow foam, two-bucket wash, iron fallout removal, clay bar, machine polish, paint sealant and tyre dressing — delivered as a single continuous process by one technician from start to finish. A full glass clean and window seal dress is included.',
                'price_from'       => 8000,
                'price_to'         => 25000,
                'duration_minutes' => 360,
                'features'         => [
                    'Snow foam + two-bucket wash with grit guard',
                    'Iron fallout spray decontamination on all panels',
                    'Clay bar glide on every painted surface',
                    'Machine polish — at least single-stage swirl removal',
                    'Synthetic paint sealant (6-month protection)',
                    'Tyre and trim dressing; window clean inside and out',
                ],
                'process' => [
                    ['title' => 'Pre-Wash & Foam',     'detail' => 'Wheels and arches pre-cleaned; snow foam applied to dwell and break down road grime.'],
                    ['title' => 'Contact Wash',        'detail' => 'Two-bucket method with wash mitt; grit guard prevents re-introduction of contamination.'],
                    ['title' => 'Decontamination',     'detail' => 'Iron fallout remover applied; clay bar worked across all panels until perfectly smooth.'],
                    ['title' => 'Correct & Seal',      'detail' => 'Machine polish removes light swirl marks; paint sealant applied for 6 months of UV and water protection.'],
                    ['title' => 'Dress & Detail',      'detail' => 'Tyre shine applied; all glass cleaned with streak-free glass cleaner; exterior plastics and rubber dressed.'],
                ],
            ],

            // ── DIAGNOSTICS & ELECTRICAL ───────────────────────────────────────────

            'obd-diagnostic-scan' => [
                'long_description' => 'We use Autel MaxiSys Ultra and LAUNCH X431 Pro — dealer-level scan tools that access every module on the vehicle, not just the powertrain. A full health check reads live data, active faults and pending codes from the engine, transmission, ABS, airbag, body and ADAS modules, and presents a prioritised report.',
                'price_from'       => 2000,
                'price_to'         => 5000,
                'duration_minutes' => 60,
                'features'         => [
                    'Autel MaxiSys Ultra or LAUNCH X431 — not a generic ELM327 reader',
                    'All modules scanned (engine, TCM, ABS, airbag, BCM, ADAS)',
                    'Live data PIDs captured and graphed',
                    'Freeze frame data preserved for intermittent faults',
                    'Printed or emailed fault report with recommended actions',
                    'Battery and alternator test included',
                ],
                'process' => [
                    ['title' => 'Vehicle Identification', 'detail' => 'VIN auto-detected; full vehicle profile confirmed before scan begins.'],
                    ['title' => 'All-System Scan',        'detail' => 'Every accessible module polled; all fault codes — stored, pending and permanent — recorded.'],
                    ['title' => 'Live Data Review',       'detail' => 'Key PIDs (fuel trims, O2 sensors, boost, coolant, etc.) reviewed against specification.'],
                    ['title' => 'Report & Consult',       'detail' => 'Prioritised fault report presented; our technician explains findings and recommends next steps.'],
                ],
            ],

            'fault-code-clearing' => [
                'long_description' => 'Clearing a code without understanding the underlying fault is irresponsible. We diagnose the root cause first, perform the repair or confirm the triggering condition is resolved, then clear the codes and perform a drive-cycle to confirm the warning light stays off.',
                'price_from'       => 1000,
                'price_to'         => 2500,
                'duration_minutes' => 30,
                'features'         => [
                    'Root-cause diagnosis performed before any code is cleared',
                    'Drive-cycle run to verify monitor completion and no re-set',
                    'Permanent codes cleared (not just soft codes)',
                    'Full scan performed after clearing to confirm clean bill',
                    'Any new codes that appear during the drive-cycle noted',
                ],
                'process' => [
                    ['title' => 'Diagnose First', 'detail' => 'Root cause of each fault confirmed; repair or condition resolution verified.'],
                    ['title' => 'Clear Codes',    'detail' => 'All stored, pending and permanent codes cleared across all modules.'],
                    ['title' => 'Drive Cycle',    'detail' => 'Road test performed to complete OBD II monitors; no re-triggering confirms successful repair.'],
                    ['title' => 'Final Scan',     'detail' => 'Post-drive scan confirms clean system before vehicle is returned.'],
                ],
            ],

            'auto-electrical-wiring-repair' => [
                'long_description' => 'Intermittent wiring faults are the most time-consuming to diagnose but we have the tooling for it: oscilloscope, thermal imaging camera, circuit tracer and manufacturer wiring diagrams for all major marques. We repair with solder-and-heat-shrink — no crimp connectors on a luxury vehicle.',
                'price_from'       => 3000,
                'price_to'         => 25000,
                'duration_minutes' => 120,
                'features'         => [
                    'Oscilloscope and thermal camera for intermittent fault tracing',
                    'Manufacturer wiring diagrams sourced for all repairs',
                    'Solder and dual-wall adhesive heat-shrink repair only',
                    'No generic crimp connectors used on European or Japanese marques',
                    'OEM-equivalent connector housings and terminals restocked',
                    'Full functional test after every repair',
                ],
                'process' => [
                    ['title' => 'Fault Map',       'detail' => 'Circuit diagram studied; fault isolated to a section of harness using voltage drop and resistance tests.'],
                    ['title' => 'Trace',           'detail' => 'Thermal camera locates heat from high-resistance joins; oscilloscope captures intermittent dropout under vibration.'],
                    ['title' => 'Repair',          'detail' => 'Damaged conductor or connector repaired with OEM-spec terminals and soldered, heat-shrunk joints.'],
                    ['title' => 'Verify',          'detail' => 'Full functional test; wiring loom reloomed and secured to prevent chafing recurrence.'],
                ],
            ],

            'alternator-testing-replacement' => [
                'long_description' => 'An undercharging alternator destroys new batteries within months. We test charging voltage, ripple and diode condition before recommending replacement. Where a remanufactured unit is available from a quality rebuilder (Bosch Exchange, WAI) we present it as a cost-saving alternative to new OEM.',
                'price_from'       => 12000,
                'price_to'         => 45000,
                'duration_minutes' => 120,
                'features'         => [
                    'Charging voltage test at idle and 2,000 rpm',
                    'AC ripple voltage test — detects failed diodes before total failure',
                    'New OEM or quality reman unit (Bosch Exchange, WAI)',
                    'Drive belt and tensioner inspection at same time',
                    'Battery registration on vehicles that require it',
                    'Post-fitment full charge cycle verified',
                ],
                'process' => [
                    ['title' => 'Test',          'detail' => 'Charging voltage and AC ripple measured under load; confirm whether replacement is needed.'],
                    ['title' => 'Removal',       'detail' => 'Drive belt removed; alternator unbolted; wiring disconnected cleanly.'],
                    ['title' => 'Fit New Unit',  'detail' => 'New or quality reman alternator fitted; belt tension set to specification.'],
                    ['title' => 'Verify',        'detail' => 'Charging voltage confirmed at 13.8–14.7 V; ripple below 50 mV AC; battery registered if required.'],
                ],
            ],

            // ── PANEL BEATING ─────────────────────────────────────────────────────

            'dent-removal-minor' => [
                'long_description' => 'Minor dents and dings from car parks and hailstone damage removed using paintless dent repair (PDR) where the paint is intact. No filler, no respray — just the metal worked back to its original position from behind using specialist PDR rods and glue-pull tabs.',
                'price_from'       => 3000,
                'price_to'         => 15000,
                'duration_minutes' => 120,
                'features'         => [
                    'PDR (paintless dent repair) for dents with no paint damage',
                    'Glue-pull system for areas with no rear access',
                    'LED reflection board for accurate metal visualisation',
                    'No filler and no respray — panel retains original paint',
                    'Same-day turnaround for most single-dent repairs',
                ],
                'process' => [
                    ['title' => 'Assessment',  'detail' => 'Dent size, depth and paint condition assessed under LED lamp; PDR feasibility confirmed.'],
                    ['title' => 'Access',      'detail' => 'Trim removed or glue tabs applied to reach the back of the dent.'],
                    ['title' => 'Work',        'detail' => 'PDR rod or glue-pull used to gradually massage metal back to level; LED board monitors progress.'],
                    ['title' => 'Finish',      'detail' => 'Panel polished; paint condition assessed; trim refitted.'],
                ],
            ],

            'panel-straightening-repainting' => [
                'long_description' => 'Full panel repair where PDR is not viable: body filler applied in minimal quantity, primer, colour-matched basecoat and clear coat, blended into adjacent panels in a temperature-controlled spray booth. We use waterborne paints and a spectrophotometer for colour matching.',
                'price_from'       => 15000,
                'price_to'         => 80000,
                'duration_minutes' => 1440,
                'features'         => [
                    'Spectrophotometer colour matching (not visual guesswork)',
                    'Waterborne basecoat in a heated, filtered spray booth',
                    'Minimum filler application — metal worked as far as possible first',
                    'Blend coat to adjacent panels for seamless finish',
                    'Infrared cure lamp for accelerated hardening',
                    'Machine polish and paint protection on completion',
                ],
                'process' => [
                    ['title' => 'Strip & Assess',    'detail' => 'Panel stripped to bare metal; structural damage assessed; any bent sub-structure pulled on frame jig.'],
                    ['title' => 'Metal Work',        'detail' => 'Panel beaten as close to original contour as possible; minimal filler needed if metal work is thorough.'],
                    ['title' => 'Prime',             'detail' => 'Etching primer applied; high-build primer sanded to perfect finish; guide coat checks for low spots.'],
                    ['title' => 'Colour & Clear',    'detail' => 'Spectrophotometer-matched basecoat applied in booth; clear coat sprayed wet-on-wet.'],
                    ['title' => 'Polish & Protect',  'detail' => 'Cured panel cut and polished to match sheen of surrounding panels; sealant applied.'],
                ],
            ],

            'full-accident-repair' => [
                'long_description' => 'Structural accident repair from initial assessment through to insurance sign-off and handover. We work with a Celette bench jig for chassis measurement and alignment, use OEM or manufacturer-approved replacement panels where possible, and document every stage for the insurance file.',
                'price_from'       => 50000,
                'price_to'         => 500000,
                'duration_minutes' => 4320,
                'features'         => [
                    'Celette frame jig measurement against manufacturer datum points',
                    'OEM or manufacturer-approved replacement panels',
                    'Insurance assessment documentation prepared',
                    'Waterborne paint in heated, filtered spray booth',
                    'Airbag and ADAS sensor calibration after any structural repair',
                    'Final full-system OBD scan and road test',
                ],
                'process' => [
                    ['title' => 'Damage Assessment',    'detail' => 'Full disassembly; hidden damage identified; written estimate prepared for insurance approval.'],
                    ['title' => 'Structural Repair',    'detail' => 'Chassis pulled to datum on Celette jig; structural sections welded or replaced to OEM specification.'],
                    ['title' => 'Panel Replacement',    'detail' => 'Damaged outer panels replaced with OEM or equivalent; gaps and shutlines set to factory tolerance.'],
                    ['title' => 'Paint',                'detail' => 'Waterborne basecoat; spectrophotometer colour match; blend coat to adjacent panels; IR cure.'],
                    ['title' => 'ADAS Calibration',     'detail' => 'Any camera, radar or ultrasonic sensor disturbed during repair calibrated to manufacturer specification.'],
                    ['title' => 'QA & Handover',        'detail' => 'Full-system OBD scan; road test; insurance documentation completed; vehicle returned detailed.'],
                ],
            ],

        ];

        $imagePool = array_values($images);
        $idx       = 0;

        foreach ($data as $slug => $attrs) {
            $updated = Service::where('slug', $slug)->update([
                'long_description' => $attrs['long_description'],
                'price_from'       => $attrs['price_from'],
                'price_to'         => $attrs['price_to'] ?? null,
                'duration_minutes' => $attrs['duration_minutes'],
                'features'         => json_encode($attrs['features']),
                'process'          => json_encode($attrs['process']),
                'image'            => $imagePool[$idx % count($imagePool)],
            ]);

            if ($updated) {
                $idx++;
            }
        }

        Cache::forget('service_categories_active');

        $this->command->info('ServiceDetailSeeder: updated ' . count($data) . ' services with detail content.');
    }
}
