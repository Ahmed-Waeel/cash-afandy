<?php

namespace App\Http\Controllers\Website;

use App\Models\Client;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Redot\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the website.
     *
     * @return View
     */
    public function __invoke()
    {
        $sliders = Slider::query()
            ->where('active', true)
            ->where('locale', app()->getLocale())
            ->latest('id')
            ->get();

        $clients = Client::query()
            ->where('active', true)
            ->latest('id')
            ->get();

        // Temporary example data — will be fetched from customer accounts later.
        $testimonials = [
            [
                'avatar' => 'https://i.pravatar.cc/150?img=12',
                'name' => 'Omar Al-Farouq',
                'title' => 'Business Analyst',
                'rating' => 4,
                'content' => __('The cashback program on Cash Afandy has been a game changer for me. It\'s the best way to save while shopping online'),
            ],
            [
                'avatar' => 'https://i.pravatar.cc/150?img=47',
                'name' => 'Reem Mostafa',
                'title' => 'Freelancer',
                'rating' => 4,
                'content' => __('The site saved me a lot of discounts on online shopping in a really easy way'),
            ],
            [
                'avatar' => 'https://i.pravatar.cc/150?img=13',
                'name' => 'Ali Hassan',
                'title' => 'Doctor',
                'rating' => 4,
                'content' => __('Through Cash Afandy I managed to save a lot on many purchases, the site is easy to use and offers exclusive deals'),
            ],
            [
                'avatar' => 'https://i.pravatar.cc/150?img=14',
                'name' => 'Nour Al-Hadi',
                'title' => 'Teacher',
                'rating' => 4,
                'content' => __('Cash Afandy gave me exclusive coupons I couldn\'t find anywhere else, along with excellent tools and services'),
            ],
            [
                'avatar' => 'https://i.pravatar.cc/150?img=15',
                'name' => 'Ahmed El-Sayed',
                'title' => 'Software Developer',
                'rating' => 5,
                'content' => __('Cash Afandy makes it easy to get access to discounts, I found excellent coupons for the products I need, and I recommend it to everyone'),
            ],
        ];

        $cashbackSteps = [
            [
                'title' => __('Sign up on :app', ['app' => app_name()]),
                'description' => __('Easily create a new account on :app or log in if you already have an account', ['app' => app_name()]),
            ],
            [
                'title' => __('Browse the cashback section'),
                'description' => __('You will find many featured stores on :app, all you have to do is choose one of them', ['app' => app_name()]),
            ],
            [
                'title' => __('Complete the purchase'),
                'description' => __('Go to the store and complete the purchase process as usual without any additional steps'),
            ],
            [
                'title' => __('Wait for the cashback in your account'),
                'description' => __('Wait for the cashback amount to appear in your account on :app, then you can withdraw it later', ['app' => app_name()]),
            ],
        ];

        // Temporary example data — will be fetched from the Coupon model later.
        $coupons = [
            [
                'title' => 'Jumia Egypt',
                'description' => __('One of the largest online shopping platforms in Egypt, offering a huge variety of products across every category.'),
                'discount' => '35%',
                'image' => 'https://picsum.photos/seed/jumia-coupon/600/300',
                'logo' => 'https://www.google.com/s2/favicons?sz=128&domain=jumia.com.eg',
            ],
            [
                'title' => 'H&M',
                'description' => __('Discover the latest fashion trends and international clothing collections for men, women, and kids.'),
                'discount' => '60%',
                'image' => 'https://picsum.photos/seed/hm-coupon/600/300',
                'logo' => 'https://www.google.com/s2/favicons?sz=128&domain=hm.com',
            ],
            [
                'title' => 'No Mercy Escape Rooms',
                'description' => __('A thrilling escape room experience packed with challenges and puzzles that test your wits under pressure.'),
                'discount' => '10%',
                'image' => 'https://picsum.photos/seed/no-mercy-coupon/600/300',
                'logo' => 'https://ui-avatars.com/api/?name=NM&background=101010&color=fff&bold=true',
            ],
            [
                'title' => 'Bazooka',
                'description' => __('A distinguished restaurant serving the finest fried chicken meals with rich flavors and a diverse menu.'),
                'discount' => '35%',
                'image' => 'https://picsum.photos/seed/bazooka-coupon/600/300',
                'logo' => 'https://ui-avatars.com/api/?name=BZ&background=CF1E30&color=fff&bold=true',
            ],
            [
                'title' => 'Jewel New Cairo',
                'description' => __('A premier entertainment and sports destination in New Cairo, offering a diverse mix of water attractions.'),
                'discount' => '50%',
                'image' => 'https://picsum.photos/seed/jewel-coupon/600/300',
                'logo' => 'https://ui-avatars.com/api/?name=J&background=0B99FF&color=fff&bold=true',
            ],
        ];

        // Temporary example data — will be fetched from the Cashback model later.
        $cashbackStores = [
            [
                'title' => 'Aqua Decorations',
                'description' => __('Get unique aquarium and fish tank decorations in a wide range of modern designs for your home.'),
                'percentage' => '1%',
                'image' => 'https://picsum.photos/seed/aqua-cashback/600/300',
                'logo' => 'https://ui-avatars.com/api/?name=AQ&background=0B99FF&color=fff&bold=true',
            ],
            [
                'title' => 'Booking.com',
                'description' => __('The world\'s leading platform for hotel reservations and vacation rentals, offering the best deals worldwide.'),
                'percentage' => '2%',
                'image' => 'https://picsum.photos/seed/booking-cashback/600/300',
                'logo' => 'https://www.google.com/s2/favicons?sz=128&domain=booking.com',
            ],
            [
                'title' => 'Ski Egypt',
                'description' => __('Egypt\'s largest indoor snow park in Africa, featuring a real penguin encounter and thrilling snow activities.'),
                'percentage' => '2.5%',
                'image' => 'https://picsum.photos/seed/ski-egypt-cashback/600/300',
                'logo' => 'https://www.google.com/s2/favicons?sz=128&domain=skiegy.com',
            ],
            [
                'title' => 'Bath & Body Works',
                'description' => __('A specialty retailer offering a wide range of body care products, fragrances, and home scents.'),
                'percentage' => '6%',
                'image' => 'https://picsum.photos/seed/bbw-cashback/600/300',
                'logo' => 'https://www.google.com/s2/favicons?sz=128&domain=bathandbodyworks.com',
            ],
            [
                'title' => 'Ubuy',
                'description' => __('A cross-border e-commerce platform offering high-quality tools, equipment, and gadgets from around the world.'),
                'percentage' => '32%',
                'image' => 'https://picsum.photos/seed/ubuy-cashback/600/300',
                'logo' => 'https://www.google.com/s2/favicons?sz=128&domain=ubuy.com',
            ],
        ];

        return view('website.index', [
            'sliders' => $sliders,
            'clients' => $clients,
            'testimonials' => $testimonials,
            'cashbackSteps' => $cashbackSteps,
            'coupons' => $coupons,
            'cashbackStores' => $cashbackStores,
        ]);
    }
}
