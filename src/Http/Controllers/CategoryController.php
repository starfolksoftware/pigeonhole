<?php

namespace StarfolkSoftware\Pigeonhole\Http\Controllers;

use StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories;
use StarfolkSoftware\Pigeonhole\Contracts\DeletesCategories;
use StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories;
use StarfolkSoftware\Pigeonhole\Pigeonhole;

class CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \StarfolkSoftware\Pigeonhole\Contracts\CreatesCategories  $createsCategories
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatesCategories $createsCategories)
    {
        $category = $createsCategories(
            request()->user(),
            request()->all(),
            request('team_id')
        );

        return request()->wantsJson() ? response()->json(['category' => $category]) : redirect()->to(
            request()->get('redirect', Pigeonhole::redirects('store', '/'))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed  $category
     * @param  \StarfolkSoftware\Pigeonhole\Contracts\UpdatesCategories  $updatesCategories
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($category, UpdatesCategories $updatesCategories)
    {
        $category = Pigeonhole::newCategoryModel()->findOrFail($category);

        $category = $updatesCategories(
            request()->user(),
            $category,
            request()->all()
        );

        return request()->wantsJson() ? response()->json(['category' => $category]) : redirect()->to(
            request()->get('redirect', Pigeonhole::redirects('update', '/'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $category
     * @param  \StarfolkSoftware\Pigeonhole\Contracts\DeletesCategories  $deletesCategories
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($category, DeletesCategories $deletesCategories)
    {
        $category = Pigeonhole::newCategoryModel()->findOrFail($category);

        $deletesCategories(
            request()->user(),
            $category
        );

        return request()->wantsJson() ? response()->json([]) : redirect()->to(
            request()->get('redirect', Pigeonhole::redirects('destroy', '/'))
        );
    }
}
