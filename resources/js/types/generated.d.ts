declare namespace App.Data {
    export type ArticleData = {
        id: number;
        title: string;
        slug: string;
        read_time: number;
        short_desc: string;
        description: string;
        image: string;
        image_path: string;
        created_at: string;
    };
    export type CategoryData = {
        id: string;
        title: string;
    };
    export type PaginatorData = {
        current_page: number;
        data: Array<App.Data.VideoData> | Array<App.Data.ArticleData>;
        first_page_url: string;
        from: number;
        last_page: number;
        last_page_url: string;
        links: Array<App.Data.PaginatorLinksData>;
        next_page_url: string | null;
        path: string;
        per_page: number;
        prev_page_url: string | null;
        to: number;
        total: number;
    };
    export type PaginatorLinksData = {
        url: string | null;
        label: string;
        page: number | null;
        active: boolean;
    };
    export type TagData = {
        id: number;
        title: string;
    };
    export type VideoData = {
        id: number;
        title: string;
        slug: string;
        short_desc: string;
        description: string;
        file_name: string;
        file_path: string;
        category: App.Data.CategoryData;
        tags: Array<App.Data.TagData>;
    };
}
declare namespace App.Enums {
    export type UserStatus = {
        name: string;
        value: string;
    };
}
declare namespace App.MoonShine.Enums {
    export type MoonshineUserRole = {
        name: string;
        value: number;
    };
}
