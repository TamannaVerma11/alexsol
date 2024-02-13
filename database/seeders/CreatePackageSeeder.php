<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageContent;
use Illuminate\Database\Seeder;

class CreatePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $package = Package::create([
            'price' => 14900,
            'user' => 1,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 1 user',
            'details' => 'The price for using the system (license) is NOK 14 900,-. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 1 bruker',
            'details' => 'Pris for bruk av system (lisens) er kr 14 900,-. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        PackageContent::create([
            'name' => 'License one year, 1 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 1 bruker',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 26890,
            'user' => 2,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 2 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of a user (NOK 1,990) which is billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 2 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av en bruker (kr 1 990,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 28880,
            'user' => 3,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 3 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of two users (NOK 3,980), which are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 3 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av to brukere (kr 3 980,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 32860,
            'user' => 4,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 4 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of four users (NOK 7,960) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 4 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av fire brukere (kr 7 960,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 34850,
            'user' => 5,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 5 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of five users (NOK 9,950) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 5 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av fem brukere (kr 9 950,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 36840,
            'user' => 6,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 6 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of six users (NOK 11,940) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 6 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av seks brukere (kr 11 940,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 38830,
            'user' => 7,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 7 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of seven users (NOK 13,930) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 7 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av syv brukere (kr 13 930,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 40820,
            'user' => 8,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 8 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of eight users (NOK 15,920) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 8 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av åtte brukere (kr 15 920,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 42810,
            'user' => 9,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 9 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of nine users (NOK 17,910) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 9 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av ni brukere (kr 17 910,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 44800,
            'user' => 10,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 10 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of ten users (NOK 19,900) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 10 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av ti brukere (kr 19 900,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 46790,
            'user' => 11,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 11 user',
            'details' => 'The price for using the system (license) is NOK 46 790,-, with the addition of eleven users (NOK 21,890) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 11 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 46 790,-, med tillegg av elleve brukere (kr 21 890,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 48780,
            'user' => 12,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 12 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of twelve users (NOK 23,880) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 12 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av tolv brukere (kr 23 880,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 50770,
            'user' => 13,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 13 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of thirteen users (NOK 25,870) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 13 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av tretten brukere (kr 25 870,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 52760,
            'user' => 14,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 14 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of fifteen users (NOK 29,850) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 14 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av fjorten brukere (kr 27 860,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);


        $package = Package::create([
            'price' => 54750,
            'user' => 15,
            'size_min' => 1,
            'size_max' => 10000
        ]);
        PackageContent::create([
            'name' => 'License one year, 15 user',
            'details' => 'The price for using the system (license) is NOK 24 900,-, with the addition of fourteen users (NOK 27,860) who are billed annually. The price of the license includes an annual half-day seminar to improve skills. Any travel costs are additional. Subscription is ongoing as an annual agreement. Termination must take place no later than three months before the end of the agreement period. All prices are excluding VAT.',
            'language_id' => 1,
            'package_id' => $package->id,
        ]);
        PackageContent::create([
            'name' => 'Lisens ett år, 15 brukere',
            'details' => 'Pris for bruk av system (lisens) er kr 24 900,-, med tillegg av femten brukere (kr 29 850,-) som faktureres årlig. Pris på lisens inkluderer et årlig kompetansehevende halv dags seminar. Eventuelle reisekostnader kommer i tillegg. Abonnement er løpende som årlig avtale. Oppsigelse må skje senest tre måneder før avtaleperiodens utløp. Alle priser er eks mva.',
            'language_id' => 2,
            'package_id' => $package->id,
        ]);

    }
}
