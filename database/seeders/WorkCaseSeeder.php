<?php

namespace Database\Seeders;

use App\Models\WorkCase;
use App\Models\WorkCaseGallery;
use App\Models\WorkCaseMetric;
use App\Models\WorkCaseStep;
use Illuminate\Database\Seeder;

class WorkCaseSeeder extends Seeder
{
    public function run(): void
    {
        WorkCaseGallery::query()->delete();
        WorkCaseMetric::query()->delete();
        WorkCaseStep::query()->delete();
        WorkCase::withTrashed()->forceDelete();

        $cases = [

            // ── 1. Porsche 911 Carrera S ─────────────────────────────────────
            [
                'case' => [
                    'title'        => 'Porsche 911 Carrera S — Paint Correction & Ceramic',
                    'slug'         => 'porsche-911-paint-correction-ceramic',
                    'category'     => 'detailing',
                    'service_type' => 'Full Paint Correction & 9H Ceramic Coating',
                    'before_image' => 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?q=80&w=1400&auto=format&fit=crop',
                    'after_image'  => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1400&auto=format&fit=crop',
                    'brief'        => 'A 2019 Porsche 911 Carrera S (992) arrived with four years of accumulated swirl marks, light buffer trails from a previous detailer, and a lackluster finish that did nothing to reflect the engineering beneath it. The owner — a daily driver who takes the car to track days — requested a full correction and durable ceramic protection.',
                    'challenge'    => 'The 992 Carrera S features Porsche\'s thin-layer silver paint which amplifies every imperfection under directional lighting. Correcting without burning through the clear coat required frequent paint depth measurements and a conservative polish schedule. The goal was 90%+ defect removal while preserving maximum clear-coat thickness.',
                    'outcome'      => 'Two-stage machine polishing removed 94% of visible defects. A certified 9H ceramic coating was applied in three stages over 38 studio hours, delivering a glass-like finish and long-term protection. The owner returned six months later for a maintenance detail and reported the coating still hydrophobic and uniform.',
                    'duration_days' => 3,
                    'completed_at'  => '2025-03-10',
                    'client_type'   => 'Private Owner — Westlands, Nairobi',
                    'is_featured'   => true,
                    'sort_order'    => 1,
                ],
                'metrics' => [
                    ['label' => 'Studio Hours',      'value' => '38'],
                    ['label' => 'Gloss Improvement', 'value' => '+22%'],
                    ['label' => 'Ceramic Grade',     'value' => '9H'],
                    ['label' => 'Defect Removal',    'value' => '94%'],
                ],
                'steps' => [
                    ['step_number' => 1, 'title' => 'Pre-wash & decontamination', 'detail' => 'Two-bucket foam wash followed by iron fallout remover and tar solvent to neutralise all bonded contamination before any abrasive work.'],
                    ['step_number' => 2, 'title' => 'Clay bar treatment', 'detail' => 'Medium-grade clay bar worked panel-by-panel to achieve a glass-smooth surface, confirmed by the plastic-bag test.'],
                    ['step_number' => 3, 'title' => 'Stage 1 paint correction', 'detail' => 'Medium-cut compound on a dual-action polisher to remove heavy swirls and oxidation. Paint depth logged every 15 cm.'],
                    ['step_number' => 4, 'title' => 'Stage 2 refinement polish', 'detail' => 'Fine finishing polish to eliminate any micro-marring introduced in Stage 1, maximising reflectivity before coating.'],
                    ['step_number' => 5, 'title' => '9H ceramic coating application', 'detail' => 'Three-layer ceramic coating applied in a climate-controlled bay and cured under IR lamps for 72 hours before the vehicle left the studio.'],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1616455579100-2ceaa4eb2d37?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1400&auto=format&fit=crop',
                ],
            ],

            // ── 2. BMW M3 Competition G80 ────────────────────────────────────
            [
                'case' => [
                    'title'        => 'BMW M3 Competition — Stage 2 ECU Calibration',
                    'slug'         => 'bmw-m3-competition-ecu-calibration',
                    'category'     => 'performance',
                    'service_type' => 'Stage 2 ECU Calibration',
                    'before_image' => 'https://images.unsplash.com/photo-1617814065893-00757125efab?q=80&w=1400&auto=format&fit=crop',
                    'after_image'  => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?q=80&w=1400&auto=format&fit=crop',
                    'brief'        => 'Owner requested measured performance gains for track use while maintaining street-driving refinement and reversibility for warranty work. The G80 M3 Competition arrived as a bone-stock 2022 model with catless downpipes already fitted by a previous workshop — a strong base for Stage 2 calibration.',
                    'challenge'    => 'Extract real-world gains from the S58 engine without compromising long-term reliability or losing the M3\'s factory character. BMW\'s OBD protection and rolling anti-tamper checksums required specialist tooling from our European calibration partner before any map changes could begin.',
                    'outcome'      => 'Significant gains in mid-range torque and top-end power, with no fault codes and improved throttle response across all driving modes. The owner competed in two Nairobi Motor Club events within a month of collection, posting his best ever track times at Targa.',
                    'duration_days' => 2,
                    'completed_at'  => '2025-02-14',
                    'client_type'   => 'Track-day Enthusiast — Karen, Nairobi',
                    'is_featured'   => false,
                    'sort_order'    => 2,
                ],
                'metrics' => [
                    ['label' => 'Peak Power Gain', 'value' => '+78 hp'],
                    ['label' => 'Peak Torque Gain', 'value' => '+92 lb-ft'],
                    ['label' => '0–100 km/h',       'value' => '−0.4 s'],
                    ['label' => 'Reversible',        'value' => 'Yes'],
                ],
                'steps' => [
                    ['step_number' => 1, 'title' => 'Baseline dyno run & data logging', 'detail' => 'Full load pulls on the Mustang dynamometer to establish stock figures and identify areas of boost, fuelling, and ignition timing that leave power on the table.'],
                    ['step_number' => 2, 'title' => 'Custom map development', 'detail' => 'Collaborated with our European S58-specialist partner to build a bespoke map targeting the hardware present: catless downpipes, stock air filter and intercooler.'],
                    ['step_number' => 3, 'title' => 'Flash & initial road session', 'detail' => 'Map flashed via ENET cable with BMW-OBD protection bypassed. Initial conservative parameters used for a 30-minute road warm-up and safety check.'],
                    ['step_number' => 4, 'title' => 'Iterative dyno tuning', 'detail' => 'Four additional dyno sessions refining boost curves, ignition advance and fuelling across the entire RPM range in all M-mode variants.'],
                    ['step_number' => 5, 'title' => 'Road test & sign-off', 'detail' => 'Two-hour road sign-off including motorway pulls and urban stop-start to confirm drivability, temperature stability, and absence of fault codes.'],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1617814065893-00757125efab?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1583121274602-3e2820c69888?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1400&auto=format&fit=crop',
                ],
            ],

            // ── 3. Mercedes-AMG GT 63 S ──────────────────────────────────────
            [
                'case' => [
                    'title'        => 'Mercedes-AMG GT 63 S — Concours Detail & Ceramic',
                    'slug'         => 'mercedes-amg-gt63s-concours-ceramic',
                    'category'     => 'detailing',
                    'service_type' => 'Concours Detail & Ceramic Coating',
                    'before_image' => 'https://images.unsplash.com/photo-1563720360172-67b8f3dce741?q=80&w=1400&auto=format&fit=crop',
                    'after_image'  => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?q=80&w=1400&auto=format&fit=crop',
                    'brief'        => 'A 2021 Mercedes-AMG GT 63 S 4-Door brought in by a corporate client ahead of entry into a concours d\'élégance event. The vehicle had been daily-driven and showed road film, light swirling on the bonnet, and a grubby engine bay. Preparation had to be completed within four days before the event deadline.',
                    'challenge'    => 'The AMG Black Magma paint is notoriously soft and prone to polishing marks if wheel speed and pressure are not controlled precisely. Simultaneously, the exterior prep had to be completed alongside a full interior leather restoration and engine bay detail — all within a single four-day window.',
                    'outcome'      => 'The GT 63 S left the studio show-ready. Paint measured defect-free under high-intensity inspection lighting. The leather interior showed no cracking after conditioning treatment and the engine bay was studio-clean. The client won the Luxury Saloon class at the event.',
                    'duration_days' => 4,
                    'completed_at'  => '2025-04-02',
                    'client_type'   => 'Corporate Client — CBD, Nairobi',
                    'is_featured'   => false,
                    'sort_order'    => 3,
                ],
                'metrics' => [
                    ['label' => 'Studio Hours',        'value' => '52'],
                    ['label' => 'Paint Reading (avg)', 'value' => '142 µm'],
                    ['label' => 'Leather Condition',   'value' => 'Restored'],
                    ['label' => 'Event Result',        'value' => 'Class Win'],
                ],
                'steps' => [
                    ['step_number' => 1, 'title' => 'Full decontamination wash', 'detail' => 'Foam pre-soak, hand wash, iron remover, tar & adhesive solvent, and clay bar on all painted surfaces including door shuts.'],
                    ['step_number' => 2, 'title' => 'Engine bay detail', 'detail' => 'Low-pressure steam clean with degreasers, hand-dressed plastic trim, and dressed engine covers for show presentation.'],
                    ['step_number' => 3, 'title' => 'Single-stage paint correction', 'detail' => 'Targeted correction on bonnet and roof using gentle cutting compound at low machine speed to preserve clear-coat depth on the soft AMG paint.'],
                    ['step_number' => 4, 'title' => 'Interior leather restoration', 'detail' => 'pH-balanced leather cleaner, brush agitation in stitching, pH-neutral conditioner applied in three coats to restore suppleness and gloss.'],
                    ['step_number' => 5, 'title' => 'Ceramic coating & final inspection', 'detail' => 'Hydrophilic ceramic coating on all painted surfaces, glass sealant on windows, and tyre dressing. Final inspection under studio raking lights before delivery.'],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1563720360172-67b8f3dce741?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1601929862178-e8c7fc9a0afc?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1400&auto=format&fit=crop',
                ],
            ],

            // ── 4. Audi RS6 Avant — PPF Full Wrap ───────────────────────────
            [
                'case' => [
                    'title'        => 'Audi RS6 Avant — Full Paint Protection Film',
                    'slug'         => 'audi-rs6-avant-ppf-full-wrap',
                    'category'     => 'bodywork',
                    'service_type' => 'Full-Body Paint Protection Film',
                    'before_image' => 'https://images.unsplash.com/photo-1606152421802-db97b9c7a11b?q=80&w=1400&auto=format&fit=crop',
                    'after_image'  => 'https://images.unsplash.com/photo-1612825173281-9a193378527e?q=80&w=1400&auto=format&fit=crop',
                    'brief'        => 'New delivery — an Audi RS6 Avant in Nardo Grey brought in directly from the dealership with zero delivery miles. The owner requested full-body PPF applied before the car touched the road, combined with a ceramic top-coat over the film for enhanced self-healing and hydrophobic properties.',
                    'challenge'    => 'The RS6\'s complex body lines and sharp character edges at the wheel arches and door shutlines demand precise panel mapping and stretch-wrap technique to avoid visible seams. New Nardo Grey paint is sensitive to contamination before full degassing — the 72-hour curing period had to be factored into the schedule.',
                    'outcome'      => 'Complete full-body PPF coverage with no visible seam lines on critical viewing angles. Ceramic top-coat activated self-healing properties across the bonnet and front wings. The owner has since accumulated 15,000 km with the paint completely unmarked.',
                    'duration_days' => 5,
                    'completed_at'  => '2025-01-20',
                    'client_type'   => 'Private Owner — Lavington, Nairobi',
                    'is_featured'   => false,
                    'sort_order'    => 4,
                ],
                'metrics' => [
                    ['label' => 'Coverage',       'value' => '100%'],
                    ['label' => 'Film Grade',     'value' => 'Self-Healing'],
                    ['label' => 'Seams Visible',  'value' => 'None'],
                    ['label' => 'Studio Hours',   'value' => '44'],
                ],
                'steps' => [
                    ['step_number' => 1, 'title' => 'Paint cure verification', 'detail' => 'New-car paint tested for full degassing with moisture meter before any film was applied. 72-hour waiting period observed.'],
                    ['step_number' => 2, 'title' => 'Panel templating & cutting', 'detail' => 'Every body section custom-mapped using digital templates to ensure edge wraps disappear into door shuts and shut lines.'],
                    ['step_number' => 3, 'title' => 'Film application — front impact zones', 'detail' => 'Bonnet, front bumper, splitter, mirror caps, and headlights wrapped first using heat-stretch technique on curved surfaces.'],
                    ['step_number' => 4, 'title' => 'Full body panel wrap', 'detail' => 'Doors, quarter panels, roof, sills, and tailgate wrapped sequentially. Each panel squeegeed, edge-tucked, and heat-set before moving to the next.'],
                    ['step_number' => 5, 'title' => 'Ceramic coating over film', 'detail' => 'Dedicated PPF-compatible ceramic coating applied in a clean room and cured under controlled temperature for 48 hours to activate self-healing.'],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1606152421802-db97b9c7a11b?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1612825173281-9a193378527e?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1400&auto=format&fit=crop',
                ],
            ],

            // ── 5. Range Rover Sport — Interior Restoration ──────────────────
            [
                'case' => [
                    'title'        => 'Range Rover Sport — Full Interior Restoration',
                    'slug'         => 'range-rover-sport-interior-restoration',
                    'category'     => 'detailing',
                    'service_type' => 'Leather & Interior Restoration',
                    'before_image' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?q=80&w=1400&auto=format&fit=crop',
                    'after_image'  => 'https://images.unsplash.com/photo-1616788494707-ec28f08d05a1?q=80&w=1400&auto=format&fit=crop',
                    'brief'        => 'A 2018 Range Rover Sport HSE Dynamic with 80,000 km presented heavily worn Windsor leather across all four seats, severe cracking on the driver\'s bolster, faded dash trim, and ingrained soiling in all headliner panels. The owner wanted the interior restored to showroom condition without reupholstering.',
                    'challenge'    => 'The level of dye wear and cracking on the driver\'s bolster exceeded what standard conditioning can address — colour sub-layer repair and professional dye recoating were required. Matching the factory Ebony leather tone across all newly treated panels to prevent visible variation was the primary technical challenge.',
                    'outcome'      => 'Seats, steering wheel, door cards, and dashboard returned to like-new condition. The driver\'s bolster crack was filled, sub-surface sealed, and dye-matched to within one Munsell step of the original. Headliner panels cleaned without disturbing adhesive bonds. The owner described the result as \'better than when I bought it\'.',
                    'duration_days' => 3,
                    'completed_at'  => '2024-12-05',
                    'client_type'   => 'Private Owner — Runda, Nairobi',
                    'is_featured'   => false,
                    'sort_order'    => 5,
                ],
                'metrics' => [
                    ['label' => 'Leather Coverage', 'value' => '100%'],
                    ['label' => 'Colour Match',     'value' => '99%'],
                    ['label' => 'Crack Repairs',    'value' => '3 Panels'],
                    ['label' => 'Studio Hours',     'value' => '24'],
                ],
                'steps' => [
                    ['step_number' => 1, 'title' => 'Deep interior vacuum & extraction', 'detail' => 'Seats removed from vehicle. Hot-water extraction on carpets and fabric headliner, air-knife blowout from all crevices.'],
                    ['step_number' => 2, 'title' => 'Leather cleaning & preparation', 'detail' => 'pH-balanced leather cleaner and soft-bristle brush agitation to remove grease and ingrained soiling without stripping factory topcoat.'],
                    ['step_number' => 3, 'title' => 'Crack repair & sub-surface work', 'detail' => 'Flexible leather filler used to bridge cracks on bolster, sanded flush and sealed with flexible primer before dye application.'],
                    ['step_number' => 4, 'title' => 'Dye matching & recoat', 'detail' => 'Spectrophotometer colour match to factory Ebony specification. Three thin airbrush coats applied for even coverage and natural texture retention.'],
                    ['step_number' => 5, 'title' => 'Protection & finishing', 'detail' => 'Premium leather conditioner and UV-inhibitor applied across all surfaces. Steering wheel wrapped and dash trim dressed with low-sheen product.'],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1616788494707-ec28f08d05a1?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1489824904134-891ab64532f1?q=80&w=1400&auto=format&fit=crop',
                ],
            ],

            // ── 6. Ferrari 488 GTB — Paintwork Restoration ───────────────────
            [
                'case' => [
                    'title'        => 'Ferrari 488 GTB — Full Paintwork Restoration',
                    'slug'         => 'ferrari-488-gtb-paintwork-restoration',
                    'category'     => 'bodywork',
                    'service_type' => 'Paintwork Restoration & Colour Unification',
                    'before_image' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?q=80&w=1400&auto=format&fit=crop',
                    'after_image'  => 'https://images.unsplash.com/photo-1592198084033-aade902d1aae?q=80&w=1400&auto=format&fit=crop',
                    'brief'        => 'A 2017 Ferrari 488 GTB in Rosso Corsa arrived following a poorly executed previous repair that had left the front bumper and left door in a visibly different red shade. The owner wanted the entire car stripped to primer on the mismatched panels and repainted to Ferrari factory specification with a full colour unification across all panels.',
                    'challenge'    => 'Rosso Corsa on a 488 is a tri-coat paint — base, mid-toner, and clear — and Ferrari\'s exact spectrophotometer formulation is not publicly available. Our paint technician spent three days on test panels blending to within imperceptible tolerance before touching the car. Masking a mid-engine supercar to prevent overspray on carbon-fibre aero pieces required bespoke masking.',
                    'outcome'      => 'All six repainted panels pass the human-eye uniformity test under direct sunlight and studio lighting. No visible transition lines at any panel shut. Ferrari service history sticker retained under masking throughout. The owner has entered the vehicle in two local concours events since completion.',
                    'duration_days' => 7,
                    'completed_at'  => '2024-11-18',
                    'client_type'   => 'Private Collector — Muthaiga, Nairobi',
                    'is_featured'   => false,
                    'sort_order'    => 6,
                ],
                'metrics' => [
                    ['label' => 'Panels Repainted',  'value' => '6'],
                    ['label' => 'Colour Delta E',    'value' => '<0.8'],
                    ['label' => 'Clear Coat Build',  'value' => '3 Coats'],
                    ['label' => 'Studio Hours',      'value' => '68'],
                ],
                'steps' => [
                    ['step_number' => 1, 'title' => 'Full disassembly & panel isolation', 'detail' => 'Front bumper, bonnet, left door, left quarter panel, and roof skin removed and stripped to bare metal / primer. Carbon aero pieces masked in place.'],
                    ['step_number' => 2, 'title' => 'Rosso Corsa colour development', 'detail' => 'Spectrophotometer readings taken from undamaged panels. Test blending on 12 sample cards over three days until Delta E < 0.8 achieved across all lighting angles.'],
                    ['step_number' => 3, 'title' => 'Primer & filler application', 'detail' => 'Epoxy primer applied to bare metal, high-build filler over repaired areas, block-sanded to 400 grit before colour coats.'],
                    ['step_number' => 4, 'title' => 'Tri-coat colour application', 'detail' => 'Base coat, mid-toner, and three coats of Ferrari-matched lacquer applied in our heated spray booth. 24-hour flash time between each layer.'],
                    ['step_number' => 5, 'title' => 'Blend, polish & reassembly', 'detail' => 'Clear coat blended into adjacent original panels using a fade-out technique. 3-stage machine polish on all painted surfaces, reassembly, and 72-hour final cure before delivery.'],
                ],
                'gallery' => [
                    'https://images.unsplash.com/photo-1592198084033-aade902d1aae?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1583121274602-3e2820c69888?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1485291571150-772bcfc10da5?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?q=80&w=1400&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=1400&auto=format&fit=crop',
                ],
            ],

        ];

        foreach ($cases as $data) {
            $case = WorkCase::create(array_merge($data['case'], [
                'is_active' => true,
            ]));

            foreach ($data['metrics'] as $metric) {
                $case->metrics()->create($metric);
            }

            foreach ($data['steps'] as $step) {
                $case->steps()->create($step);
            }

            foreach ($data['gallery'] as $i => $url) {
                $case->gallery()->create([
                    'image_path'  => $url,
                    'sort_order'  => $i,
                ]);
            }
        }
    }
}
