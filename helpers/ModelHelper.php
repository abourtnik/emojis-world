<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $count
 * @property string|null $slug
 * @property string|null $emoji
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Emoji> $emojis
 * @property-read int|null $emojis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereEmoji($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCategory {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $emoji
 * @property string $unicode
 * @property int $category_id
 * @property int $sub_category_id
 * @property int|null $parent_id
 * @property int $count
 * @property numeric|null $version
 * @property mixed|null $keywords
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Emoji> $children
 * @property-read int|null $children_count
 * @property-read Emoji|null $parent
 * @property-read \App\Models\SubCategory $subCategory
 * @method static \Database\Factories\EmojiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji filter(array $filters = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereEmoji($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereUnicode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Emoji withoutChildren()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEmoji {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $ip
 * @property bool $banned
 * @property int $ignored
 * @method static \Database\Factories\IpFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ip query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ip whereBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ip whereIgnored($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ip whereIp($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperIp {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $method
 * @property string $url
 * @property int $response_status in milliseconds
 * @property int $response_time
 * @property \Illuminate\Support\Carbon $date
 * @property string $ip
 * @property string $user_agent
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereResponseStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereResponseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Log whereUserAgent($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLog {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property int $count
 * @property-read \App\Models\Category $category
 * @method static \Database\Factories\SubCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereName($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSubCategory {}
}

